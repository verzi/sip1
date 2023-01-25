<?php
namespace App\Controller;

use RestApi\Controller\ApiController as PluginRestApiApiController;
use Cake\Network\Http\Client;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Collection\Collection;
use Cake\Utility\Hash;
use Cake\Cache\Cache;

abstract class ApiController extends PluginRestApiApiController
{
    protected $http = null;
    
    protected $proxy = null;

    protected $httpClientConfig = null;

    protected $paginationOffset = 0;

    protected $paginationLimit = 50;

    /**
     * Si está seteado en TRUE, se imprimirá directamente la respuesta recibida en el layout direct_response.ctp
     * @var boolean
     */
    protected $directResponse = false;

    /**
     * Enable cache
     *
     * @var boolean
     */
    protected $cacheEnabled = false;

    protected $queryStringParams = [];

    public abstract function setApiData();

    public function initialize()
    {
        parent::initialize();
        $this->cacheEnabled = !Configure::read('debug');
        $this->responseFormat['developerMessage'] = (null !== Configure::read('ApiRequest.responseFormat.developerMessage')) ? Configure::read('ApiRequest.responseFormat.developerMessage') : '';
        $this->responseFormat['userMessage'] = (null !== Configure::read('ApiRequest.responseFormat.userMessage')) ? Configure::read('ApiRequest.responseFormat.userMessage') : '';
        $this->responseFormat['errorCode'] = (null !== Configure::read('ApiRequest.responseFormat.errorCode')) ? Configure::read('ApiRequest.responseFormat.errorCode') : '';
        $this->responseFormat['moreInfo'] = (null !== Configure::read('ApiRequest.responseFormat.moreInfo')) ? Configure::read('ApiRequest.responseFormat.moreInfo') : '';

        $this->setApiData();
    }

    public function beforeFilter(Event $event)
	{
	    parent::beforeFilter($event);
        $this->setCORS();
        $this->setResponseType();
        $this->setQueryStringParameters();

	    if ( array_key_exists(MJDH_API_STANDARDS_MOCKED, $this->request->query) ){

	    	if ( MJDH_ENVIRONMENT_PRODUCTION === Configure::read('App.environment') ){
	    		$this->httpStatusCode = 400;
	    		$this->renderError();
	    	} else {
            }

	    }
	}

    public function setResponseType(){
        if ('xml' === Configure::read('ApiRequest.responseType')) {
            $this->response->type('xml');
        } else {
            $this->response->type('json');
        }
    }

   public function setCORS(){
       $this->response->header('Access-Control-Allow-Origin', Configure::read('ApiRequest.cors.origin'));
       /*$this->response->header('Access-Control-Allow-Methods', Configure::read('ApiRequest.cors.allowedMethods'));
       $this->response->header('Access-Control-Allow-Headers', Configure::read('ApiRequest.cors.allowedHeaders'));*/
       $this->response->header('Access-Control-Max-Age', Configure::read('ApiRequest.cors.maxAge'));
   }

    public function getQueryStringParameters(){
        $queryStringParams = [];
        if ( !empty($this->request->query)){
            foreach ($this->request->query as $key => $value) {
                if ( !is_null($this->request->query($key)) ){
                    $queryStringParams[$key] = $value;    
                }
            }
        }
        return $queryStringParams;
    }

    public function setQueryStringParameters(){
        $queryStringParams = [];
        if ( !empty($this->request->query)){
            foreach ($this->request->query as $key => $value) {
                if ( !is_null($this->request->query($key)) ){
                    $queryStringParams[$key] = $value;    
                }
            }
        }
        $this->queryStringParams = $queryStringParams;
    }

    /**
     * Before render callback.
     *
     * @param Event $event The beforeRender event.
     * @return \Cake\Network\Response|null
     */
    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);

        $this->set('directResponse', $this->directResponse);
        
        if (200 != $this->httpStatusCode) {
	        $this->renderError();
        } else {
	        $response = [
	            //$this->responseFormat['statusKey'] => $this->responseStatus
	        ];

	        if (!empty($this->apiResponse)) {
	            $response[$this->responseFormat['resultKey']] = $this->apiResponse;
	        }

            if ( $this->directResponse !== true ){
                $this->set('response', $response);
            } else {
                $this->set('response', $this->apiResponse);
            }

	        $this->set('responseFormat', $this->responseFormat);
	        $this->viewBuilder()->className('Api');
	        
	        return null;
	    }
    }

    /**
     * Logs the request and response data into database.
     *
     * @param Request  $request  The \Cake\Network\Request object
     * @param Response $response The \Cake\Network\Response object
     */
    /*public static function log()
    {
        debug($this->request);exit;
        try {
            $entityData = [
                'http_method' => $this->request->method(),
                'endpoint' => $this->request->here(),
                'token' => Configure::read('accessToken'),
                'ip_address' => $this->request->clientIp(),
                'request_data' => json_encode($this->request->data),
                'response_code' => $this->response->statusCode(),
                'response_type' => Configure::read('ApiRequest.responseType'),
                'response_data' => $this->response->body(),
                'exception' => Configure::read('apiExceptionMessage'),
            ];
        } catch (\Exception $e) {
            return;
        }
    }*/

    public function renderError(){
        $response = $this->apiResponse;
        
        if ( $this->directResponse !== true ){
        	$response = [
            	'status' => $this->httpStatusCode,
    			'developerMessage' => $this->responseFormat['developerMessage'],
    			'userMessage' => $this->responseFormat['userMessage'],
    			'errorCode' => $this->responseFormat['errorCode'],
    			'moreInfo' => $this->responseFormat['moreInfo']
            ];    
        }
        $this->response->statusCode($this->httpStatusCode);
        $this->set('response', $response);
	    $this->set('responseFormat', $this->responseFormat);

	    $this->viewBuilder()->className('Api');
        return null;
    }


    public function getHttpBaseTarget(){
        if ( $this->http ){
            $httpConfig = $this->http->config();
            $scheme = isset($httpConfig['scheme']) ? $httpConfig['scheme'] : '';
            $host = isset($httpConfig['host']) ? $httpConfig['host'] : '';
            return $scheme . '://'. $host;
        }
        return '';
    }

    protected function getPaginationOffset(){
        return (!empty($this->request->query['offset']) && is_numeric($this->request->query['offset']) && $this->request->query['offset'] > 0 ) ? (int) $this->request->query['offset'] : $this->paginationOffset;
    }

    protected function getPaginationLimit(){
        return (!empty($this->request->query['limit']) && is_numeric($this->request->query['limit']) && $this->request->query['limit'] > 0) ? (int)$this->request->query('limit') : $this->paginationLimit;
    }

    /**
     * Pagina un array
     *
     * @param array $items
     * @return array $items Items paginados
     */
    protected function apiPaginate($items = array()){
        $offset = $this->getPaginationOffset();
        $limit = $this->getPaginationLimit();
        $totalItems = count($items);
        $items = array_slice($items, $offset, $limit);
        return $items;
    }

    /**
     * Aplica los filtros a un array
     *
     * @param array $items
     * @return array $items Items filtrados
     */
    public function applyFilters($items = array()){
        if (!is_array($items)){
            return $items;
        }

        $collection = $this->transformCollectionItemsToArray($items);
        $collection = new Collection($collection);

        /**
         * START: FIELDS
         */
        if ( $this->request->query('fields') ){

            $fields = explode(',', $this->request->query('fields'));

            $collection = $collection->toArray();
            
            foreach ($collection as $key => $item) {
                $itemKeys = array_keys(Hash::flatten($item));
                $fieldsDiff = array_diff($itemKeys, $fields);
                foreach ($fieldsDiff as $fKey => $itemKeyValue) {
                    $collection = Hash::remove($collection, '{n}.'.$itemKeyValue);
                }
            }

            $collection = new Collection($collection);
        }
        /**
         * END: FIELDS
         */

        /**
         * START: SORT
         */
        if ( $this->request->query('sort') ){
            $sort = explode(',', $this->request->query('sort'));
            $field = $direction = $sortType = "";
            /**
             * TODO: Hacer que funcione el chain en las invocaciones, ya que ahora sólo ordena por 1 campo
             * 
             * Objetivo: $collection->sortBy("Nombre", SORT_ASC, SORT_STRING)->sortBy("Apellido", SORT_DESC, SORT_STRING);
             */
            foreach ($sort as $key => $value) {
                $sortDesc = substr($value, 0, 1) === "-";
                $direction = ( $sortDesc ) ? SORT_DESC : SORT_ASC;
                $v = ( $sortDesc ) ? substr($value, 1, strlen($value)-1) : $value;
                $val = $collection->first();
                if ( !isset($val[$v]) ){
                    return $collection->toArray();
                }
                $val = $val[$v];
                if ( is_string($val) ){
                    $sortType = SORT_STRING;
                } else if ( is_scalar($val) ) { 
                    $sortType = SORT_NUMERIC;
                }else{
                    $sortType = SORT_STRING;
                }

                $collection = $collection->sortBy($v, $direction, $sortType);
            }
        }
        /**
         * END: SORT
         */

        /**
         * START: FILTER FIELDS
         */
        $queryStringParameters = $this->getQueryStringParameters();
        $resourceProperties = $this->getResourceProperties($collection);
        $filterConditions = [];
        if ( !is_null($resourceProperties) ){
            foreach ($queryStringParameters as $key => $value) {
                if ( in_array($key, $resourceProperties) ){
                    $filterConditions[$key] = $value;
                }
            }
        }
        
        if (!empty($filterConditions)){
            $collection = new Collection($collection->toArray());
            $collection = $collection->filter(function ($resource, $key) use ($filterConditions) {
                $r = true;
                foreach ($filterConditions as $keyFilterConditions => $value) {
                    if ( isset($resource[$keyFilterConditions]) ){
                        $r = $r && ($resource[$keyFilterConditions] == $value );
                    }
                }
                return $r;
            });
        }
         /**
         * END: FILTER FIELDS
         */

        return $collection->toArray();
    }

    /**
     * Genera un MD5 con la url del request, concatendo con un | y finalmente con un json_encode de los paramteros GET
     *
     * @return String md5
     */
    protected function generateCacheName(){
        return md5($this->request->getParam('url') . '|' . json_encode($this->request->params));
    }

    /**
     * Dado un array como resultado de un GET, prepara la respuesta con el formato acorde a lo esperado por Modernización
     * y lo setea en apiResponse
     *
     * @param array $items
     * @return void
     */
    protected function setIndexResponse( $items = array() ){
        $items = $this->applyFilters($items);
        $items = $this->apiPaginate($items);
        $totalItems = count($items);
        
        $offset = $this->getPaginationOffset();
        $limit = $this->getPaginationLimit();

        $resp = [
            'metadata' => [
                "resultset" => [
                    "count" => $totalItems,
                    "offset"=> $offset,
                    "limit"=> $limit
                ]
            ], 
            'results' => $items
        ];

        $data = [
            'httpStatusCode' => (int)$this->httpStatusCode,
            'apiResponse' => $resp,
            'responseFormat' => [
                'userMessage' => (string) $this->responseFormat['userMessage']
            ]
        ];

        $data = json_encode($data, true);
        Cache::write($this->generateCacheName(), $data);
        $this->apiResponse = $resp;
    }

    /**
     * Dado un array como resultado de un GET, prepara la respuesta con el formato acorde a lo esperado por Modernización
     * y lo setea en apiResponse
     *
     * @param array $items
     * @return void
     */
    protected function setViewResponse( $items = array(), $conditions ){
        $collection = $this->transformCollectionItemsToArray($items);
        $collection = new Collection($collection);
        $resp = $collection->firstMatch($conditions);
        
        if ( is_null($resp) ){
            $this->directResponse = false;
            $this->httpStatusCode = 404;
            $this->responseFormat['userMessage'] = "Registro inexistente";
            $this->renderError();
        }

        $data = [
            'httpStatusCode' => (int)$this->httpStatusCode,
            'apiResponse' => $resp,
            'responseFormat' => [
                'userMessage' => (string) $this->responseFormat['userMessage']
            ]
        ];
        $data = json_encode($data, true);
        Cache::write($this->generateCacheName(), $data);
        $this->apiResponse = $resp;
    }

    /**
     * Si el elemento de la collection es de tipo Object, lo castea a Array
     *
     * @param Collection $collection
     * @return Collection
     */
    protected function transformCollectionItemsToArray($collection){
        $c = $collection;
        if (is_array($c)){
            try{
                foreach ($c as $key => $item) {
                    $it = $item;
                    if ( is_object($item) ){
                        $it = (array) $item;
                    }
                    $c[$key] = $it;
                }
            } catch (Exception $exc) {

            }
        }

        return $c;
    }

    /**
     * Retorna los atributos del recurso
     *
     * @param Collection $collection
     * @param Boolean $strtolower default false
     * @return array|null
     */
    protected function getResourceProperties($collection, $strtolower = false){
        $collection = $collection->first();
        if ( $collection ){
            $collection = $this->transformCollectionItemsToArray($collection);
            if ( is_array($collection) ){
                $collection = array_keys($collection);
                if ( $strtolower ){
                    $collection = array_map('strtolower', $collection);
                }
                return $collection;
            }
        }
        return null;
    }

    /**
     * Retorna el mapeo entre las propiedades de la entidad y su correspondiente en query string
     * 
     * Ej: NombreCompleto -> nombrecompleto
     *
     * @param [type] $resourceProperties
     * @return array
     */
    protected function getMappedQueryStringParameters($resourceProperties = array()){
        $map = array();
        foreach($resourceProperties as $key)
        {
            $map[strtolower($key)]=$key;
        }
        return $map;
    }

}