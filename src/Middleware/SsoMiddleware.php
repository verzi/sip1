<?php

namespace App\Middleware;

use Cake\Core\Exception\Exception;
use Cake\Http\Client;
use Cake\Utility\Inflector;
use Cake\Core\Configure;
use Cake\Cache\Cache;
use Cake\Log\Log;

class SsoMiddleware {

    const SSO_ERROR = 'sso_error';
    const SSO_DEBUG = 'sso_debug';
    const MSJ_INACTIVE_TOKEN = "No autorizado";
    const MSJ_UNAUTHORIZE_ROL = "No posee permisos para realizar esta acción";
    const MSJ_PUBLIC_TOKEN_INVALID_SSO_PRIVATE = "Token público inválido en SSO privado"; //No motrar al usuario
    const MSJ_NOT_SET_AUTHORIZATION_HEADER = "El header Authorization no está seteado";
    const MSJ_INVALID_AUTHORIZATION_HEADER = "Authorization header inválido";
    const MSJ_AN_ERROR_HAS_OCURRED = "Un error ha ocurrido";
    const MSJ_SSO_CONFIG_MISSING = "No existe configuración para el SSO";

    private $accessToken;
    private $tokenPublico;
    private $tokenPrivado;
    private $sso = [];
    private $errorResponse = [
        'status' => 500,
        'developerMessage' => "",
        'userMessage' => "",
        'errorCode' => "",
        'moreInfo' => ""
    ];

    /**
     * Método principal invocado por el Middleware
     * 
     * 1) Valida que la estructura del request y su token público sea válido
     * 2) Verifica Roles con su routing correspondiente
     * 3) Si todo está ok, setea el token privado en el request para que pueda ser consumido
     * 
     * @param Object $request
     * @param Object $response
     * @param Object $next
     * @return Object $response
     */
    public function __invoke($request, $response, $next) {
        Log::debug($request, self::SSO_DEBUG);
        try {
            //valida que E configuracion del sso 
            if (!Configure::check('Sso')) {
                $this->setErrorResponse(array('status' => 500, 'userMessage' => self::MSJ_SSO_CONFIG_MISSING));
                throw new Exception(self::MSJ_SSO_CONFIG_MISSING);
            }
            //lee configuracion sso
            $this->sso = Configure::read('Sso');
            //valida token publico
            if (!$this->isSetAuthorizationHeader($request)) {
                $this->setErrorResponse(array('status' => 401, 'userMessage' => self::MSJ_INACTIVE_TOKEN));
                throw new Exception(self::MSJ_INACTIVE_TOKEN);
            }
            //valida rol del token publico
            // routing sso
            // if (!$this->isRolAuthorizeRoutingSso($request)) {
            if (!$this->isRolAuthorize($request)) {
                $this->setErrorResponse(array('status' => 403, 'userMessage' => self::MSJ_UNAUTHORIZE_ROL));
                throw new Exception(self::MSJ_UNAUTHORIZE_ROL);
            }
            //obtiene token privado 
            //TODO refact este modulo en otro middlware encolado (de ser necesario)
            if (!$this->getClientSsoPrivado()) {
                Log::error(self::MSJ_PUBLIC_TOKEN_INVALID_SSO_PRIVATE, self::SSO_ERROR);
                $this->setErrorResponse(array('status' => 401, 'userMessage' => self::MSJ_INACTIVE_TOKEN));
                throw new Exception(self::MSJ_AN_ERROR_HAS_OCURRED);
            }
        } catch (Exception $exc) {
            Log::error($exc->getMessage(), self::SSO_ERROR);
            //set Exception msg => developerMessage 
            $this->setErrorResponse(array('developerMessage' => $exc->getMessage()));
            $response = $response->withStatus($this->errorResponse['status'])->withType('json');
            $response = $this->setBodyErrorResponse($response);
            return $response;
        }

        $request = $request->withAttribute('Private-SSO-Token', $this->getTokenPrivado());
        $response = $next($request, $response);

        Log::debug($response, self::SSO_DEBUG);
        return $response;
    }

    /**
     * Valida que el token del request tenga permisos para consumir el plugin, controller y action
     *
     * @param Object $request
     * @return Boolean
     */
    public function isRolAuthorizeRoutingSso($request) {
        if ((!empty($this->accessToken)) && (!empty($this->accessToken->role))) {
            //se obtienen los params del request
            $params['plugin'] = (!empty($request->params)) ? $request->params['plugin'] : "";
            //underscore controller    ApiController => api_controller 
            $params['controller'] = (!empty($request->params)) ? Inflector::underscore($request->params['controller']) : "";


            $roles = $this->getRolesRoutingSso();
            //se busca rol acorde al api.controller
            foreach ($roles as $key => $value) {
                $exploded = explode('-', $value->controllers[0]->name);
                $val['plugin'] = isset($exploded[1]) ? $exploded[0] : '';
                $val['controller'] = isset($exploded[1]) ? $exploded[1] : $exploded[0];
                $actions = $value->controllers[0]->actions;

                if (array_keys(array_intersect($params, $val)) == array('plugin', 'controller') && (in_array($request->params['action'], $actions) || in_array('*', $actions))) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Valida que el token del request tenga permisos para consumir el plugin, controller y action
     *
     * @param Object $request
     * @return Boolean
     */
    public function isRolAuthorize($request) {
        if ((!empty($this->accessToken)) && (!empty($this->accessToken->role))) {
            //se obtienen los params del request
            $params['plugin'] = (!empty($request->params)) ? $request->params['plugin'] : "";
            //underscore controller    ApiController => api_controller 
            $params['controller'] = (!empty($request->params)) ? Inflector::underscore($request->params['controller']) : "";
            //se obtiene roles declarados en api (config api.php)
            $roles = Configure::read('ApiRequest')['routing'];

            //se busca rol acorde al api.controller
            foreach ($roles as $key => $value) {
                if ((array_keys(array_intersect($params, $value))) == array('plugin', 'controller')) {
                    $routing[] = $key;
                }
            }
            if (!isset($routing)) {
                return false;
            }
            $routing = (!is_array($routing)) ? array($routing) : $routing;
            //se obtienen los roles que mapean con los declarados en ApiRequest.rountig
            $routing = (array_intersect($routing, $this->accessToken->role));

            //se valida que al menos uno de los roles tenga acceso
            foreach ($routing as $rol) {
                //se valida que existan acciones en el rol del rounting
                if (!empty($roles[$rol]['action'])) {
                    //si el action = *   todas las acciones publicas pueden ser accedidas
                    if ($roles[$rol]['action'] == '*') {
                        return true;
                    }
                    //se obtienen cada accion separada por ',' con trim
                    $actions = array_map('trim', explode(",", $roles[$rol]['action']));

                    //se valida que las acciones del routing sea a la que se esta accediendo
                    if (in_array($request->params['action'], $actions)) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function getAccessToken() {
        return $this->accessToken;
    }

    public function getTokenPublico() {
        return $this->tokenPublico;
    }

    public function getTokenPrivado() {
        return $this->tokenPrivado;
    }

    /**
     * Se valida que: 
     * 1) Exista el header Authorization
     * 2) El header Authorization sea Bearer
     * 3) El token recibido haya sido entregado por el SSO Público
     *
     * @param Object $request
     * @return Boolean
     */
    private function isSetAuthorizationHeader($request) {
        if (!$request->hasHeader('Authorization')) {
            Log::error(self::MSJ_NOT_SET_AUTHORIZATION_HEADER, self::SSO_ERROR);
            $this->setErrorResponse(array('developerMessage' => self::MSJ_NOT_SET_AUTHORIZATION_HEADER));
            return false;
        }
        $authorization = $request->header('Authorization');
        $authorization = explode("Bearer ", $authorization);

        if (count($authorization) != 2) {
            Log::error(self::MSJ_INVALID_AUTHORIZATION_HEADER, self::SSO_ERROR);
            $this->setErrorResponse(array('developerMessage' => self::MSJ_INVALID_AUTHORIZATION_HEADER));
            return false;
        }
        //read instropect public sso chache
        $token_access = Cache::read('token_introspect_sso_' . md5($authorization[1]), '_5_minute_');
        if ($token_access !== false) {
            $this->setAccessToken($token_access);
            $this->setTokenPublico($authorization[1]);
            return true;
        }
        //se valida token
        return $this->postIntrospectPublicoSso($authorization[1]);
    }

    /**
     * POST al Introspect del SSO Público para validar que el token esté activo
     *
     * @param String $token
     * @return Boolean
     */
    private function postIntrospectPublicoSso($token) {
        //se genera autorizacion = scope_id:scope_password en base 64
        $Authorization = base64_encode($this->getSsoPublico()['scope_server'] . ":" . $this->getSsoPublico()['scope_secret']);
        //set options, headers and ssl verify
        $options = array(
            'headers' => array(
                'Accept' => 'application/json',
                'Accept-Charset' => 'UTF-8',
                'Accept-Encoding' => 'identity',
                'Authorization' => 'Basic ' . $Authorization,
            ),
            'ssl_verify_peer' => false
        );

        $http = new Client($options);
        //request
        $response = $http->post($this->getSsoPublico()['Authority'] . "connect/introspect", 'token=' . $token);


        //validacion result
        if ($response->code == 200) {
            $token_access = json_decode($response->body());
            if ($token_access->active) {
                $this->setAccessToken($token_access);
                $this->setTokenPublico($token);
                //set cache 5minute.
                Cache::write('token_introspect_sso_' . md5($token), $token_access, '_5_minute_');
                return true;
            }
        }
        return false;
    }

    /**
     * Se setea el body con los errores correspondientes
     *
     * @param Object $response
     * @return Object $response
     */
    private function setBodyErrorResponse($response) {
        $body = $response->getBody();
        $body->write(json_encode($this->errorResponse));
        return $response;
    }

    /**
     * Comprobación del token cliente del SSO privado (si esta en cache o no). 
     * En caso de no estarlo, consume postTokenChainPrivadoSso() para obtener un token
     *
     * @return Boolean
     */
    private function getClientSsoPrivado() {
        //read cache client sso priv => este chache es guardado con el md5 del token publico relacionado
        $tokenPrivado = Cache::read('token_cliente_sso_priv_' . md5($this->getTokenPublico()), '_cake_short_');
        if ($tokenPrivado !== false) {
            $this->tokenPrivado = $tokenPrivado;
            return true;
        }
        //se valida token
        return $this->postTokenChainPrivadoSso();
    }

    /**
     * POST al endpoint del SSO Privado para obetener un token. Se debe enviar el token público como parámetro
     *
     * @return Boolean
     */
    private function postTokenChainPrivadoSso() {
        //set options, headers and ssl verify
        $options = array(
            'headers' => array(
                'Accept' => 'application/json',
                'Accept-Charset' => 'UTF-8',
                'Accept-Encoding' => 'identity',
            ),
            'ssl_verify_peer' => false
        );
        //set data
        $data = $this->getSsoPrivado();
        //remove Authority of data
        unset($data['Authority']);

        $http = new Client($options);
        //request
        $response = $http->post($this->getSsoPrivado()['Authority'] . "connect/token", $data);
        //validacion result
        if ($response->code == 200) {
            $responseBody = json_decode($response->body());
            if (key_exists("access_token", $responseBody)) {
                $this->tokenPrivado = $responseBody->access_token;
                //set cache 1hs.
                Cache::write('token_cliente_sso_priv_' . md5($this->getTokenPublico()), $responseBody->access_token, '_cake_short_');
                return true;
            }
        }
        return false;
    }

    /**
     * Devuelve los roles / routing cargados en el sso público para servicios.jus.gob.ar
     *
     * @param -
     * @return Boolean
     */
    private function getRolesRoutingSso() {
        $roles_cache = false; //Cache::read('sso_publ_roles_routing', '_1_day_');

        if ($roles_cache) {
            return $roles_cache;
        }

        if ($this->postTokenRolesPublicoSso()) {
            $options = array(
                'headers' => array(
                    'Authorization' => 'Bearer ' . $this->getTokenRolesRoutingSso()
                ),
                'host' => 'intratesting2.jus.gov.ar/identity/api/sistemas/servicios.jus.gob.ar/',
                'scheme' => 'https',
                'ssl_verify_peer' => false,
                'ssl_verify_peer_name' => false,
            );


            $http = new Client($options);
            $response = $http->get("/permissions");

            if ($response->code == 200) {
                $responseBody = json_decode($response->body());
                if (key_exists("roles", $responseBody)) {
                    //set cache 1 día.
                    Cache::write('sso_publ_roles_routing', $responseBody->roles, '_1_day_');
                    return $responseBody->roles;
                }
            }
        }

        return false;
    }

    /**
     * Pide el token para consultar los roles / routing del sso público
     *
     */
    private function postTokenRolesPublicoSso() {
        //set options, headers and ssl verify
        $options = array(
            'headers' => array(
                'Accept' => 'application/json',
                'Accept-Charset' => 'UTF-8',
                'Accept-Encoding' => 'identity',
            ),
            'ssl_verify_peer' => false
        );
        //set data
        $data = $this->getSsoPublicoRoles();
        //  debug($this->getSsoPublicoRoles()['Authority'] . "connect/token"); //exit;
        //remove Authority of data
        unset($data['Authority']);

        $http = new Client($options);
        //  debug($http ); exit;
        //request
        $response = $http->post($this->getSsoPublicoRoles()['Authority'] . "connect/token", $data);

        //validacion result
        if ($response->code == 200) {
            $responseBody = json_decode($response->body());
            if (key_exists("access_token", $responseBody)) {
                $this->tokenPublicoRoles = $responseBody->access_token;
                return true;
            }
        }
        return false;
    }

    private function getSsoPublico() {
        return $this->sso['publico'];
    }

    private function getSsoPrivado() {
        return $this->sso['privado'];
    }

    private function setTokenPublico($token) {
        $this->tokenPublico = $token;
        $this->sso['privado']['oauth_token'] = $token;
    }

    public function getTokenRolesRoutingSso() {
        return $this->tokenPublicoRoles;
    }

    private function getSsoPublicoRoles() {
        return $this->sso['cliente_roles'];
    }

    private function setAccessToken($accessToken) {
        if (!empty($accessToken->role)) {
            $accessToken->role = (!is_array($accessToken->role)) ? array($accessToken->role) : $accessToken->role;
        }
        $this->accessToken = $accessToken;
    }

    private function setErrorResponse($error = array()) {
        if ((!empty($error)) && (is_array($error))) {
            $this->errorResponse = array_intersect_key($error, $this->errorResponse) + ($this->errorResponse);
        }
    }

}
