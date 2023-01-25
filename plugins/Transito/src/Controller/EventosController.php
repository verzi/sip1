<?php

namespace Transito\Controller;

use Transito\Controller\ApiController;
use Cake\Cache\Cache;

class EventosController extends ApiController {

    // protected $paginationLimit = 50;
    // protected $paginationOffset = 0;

    protected $cacheEnabled = true;


    public function initialize() {
        parent::initialize();
    }

    /**
     * @api {get} /transito/api/v1.0/eventos Eventos
     * @apiVersion 1.0.0
     * @apiName IndexEventos
     * @apiGroup Transito
     *
     * @apiDescription Retorna los eventos, posiblemente no programados, en el tránsito.<br/> 
     *
     * @apiParam (Query string) {String} [sort] Permite ordenar por un campo (del primer nivel) de forma ascendente o descendente. Para ordenar de forma descendente se debe poner como prefijo del campo un -
     *
     * ```
     * ?sort=id (orden ascendente por campo id)
     * ```
     * ```
     * ?sort=-id (orden descendente por campo id)
     * ```
     * @apiParam (Query string) {String} [limit] Indica la cantidad máxima de elementos a retornar.
     *
     * ```
     * ?limit=5
     * ```
     * @apiParam (Query string) {String} [offset] Indica desde que posición se entregarán los elementos.
     *
     * ```
     * ?offset=10
     * ```
     * 
     * @apiParam (Query string) {String} [month] Año y mes del cual pediremos la información. El formato esperado es YYYY-MM (Ej.: 2019-12)
     *
     * ```
     * ?month=2019-12
     * ```
     * 
     * @apiParam (Query string) {String} provider Proveedor de datos. Podemos elegir: <ul><li><strong>1</strong>: BA Tránsito</li><li><strong>201</strong>: Transporte Público</li><li><strong>769</strong>: Accidentes Observatorio Seguridad Vial (sólo históricos)</li></ul>
     *
     * ```
     * ?provider=1
     * ```
     *
     * @apiExample Ejemplo de uso:
     *  GET /transito/api/v1.0/eventos HTTP/1.1
     *  Host: sip1.verzi.com.ar
     *  Cache-Control: no-cache
     *
     * @apiSuccessExample {json} Success-Response:
     * GET 'http://sip1.verzi.com.ar/transito/api/v1.0/eventos?provider=1&offset=0&limit=1'
     * HTTP/1.1 200 Ok
     * 
     *   {
     *       "metadata":{
     *           "resultset":{
     *               "count":1,
     *               "offset":0,
     *               "limit":1
     *           }
     *       },
     *       "results":[
     *           {
     *               "code":"2197622",
     *               "division":"BA",
     *               "type":"Emergencia",
     *               "subtypeCodes":"2262",
     *               "subtypeNames":"Incendio",
     *               "status":"Terminado",
     *               "organization":"BA",
     *               "userName":"Facundo Drucaroff",
     *               "description":"Buenos Aires: Debido a Incendio en Área Buenos Aires en GREGORIO DE LAFERRERE (N) en AV. ESCALADA",
     *               "impact":"Menor",
     *               "numAffectedLanes":0,
     *               "article":"en",
     *               "nodeFromCode":"1_-34.654797+-58.482655",
     *               "networkPointFromCode":"1572538073827",
     *               "networkPointFromName":"GREGORIO DE LAFERRERE @ AV. ESCALADA",
     *               "networkPointFromType":"Nodo",
     *               "networkPointFromLinkCode":"1_-525489_0",
     *               "networkPointFromLinkName":"GREGORIO DE LAFERRERE",
     *               "networkPointFromRoadWayCode":"1_1.30651973634",
     *               "networkPointFromRoadWayName":"GREGORIO DE LAFERRERE (N)",
     *               "fromLat":-34.6547966003418,
     *               "fromLon":-58.4826545715332,
     *               "createTimestamp":"2020-05-01T23:34:36",
     *               "openTimestamp":"2020-05-01T23:34:36",
     *               "updateTimestamp":"2020-05-02T01:36:23",
     *               "statusTimestamp":"2020-05-02T01:36:23",
     *               "startTimestamp":"2020-05-01T23:34:46",
     *               "endTimestamp":"2020-05-02T01:36:23",
     *               "notifierType":"CGM",
     *               "numPeopleInvolved":0,
     *               "seriouslyInjuredPeople":0,
     *               "minorInjuredPeople":0,
     *               "uninjuredPeople":0,
     *               "casualtiesPeople":0,
     *               "numVehicleInvolved":0,
     *               "lightVehicle":0,
     *               "heavyVehicle":0,
     *               "otherVehicle":0,
     *               "totalLanes":0
     *           }
     *       ]
     *   }
     *
     * @apiSampleRequest http://sip1.verzi.com.ar/transito/api/v1.0/eventos
     * @apiError Error   Posible error.
     *
     * @apiErrorExample Response (ejemplo):
     *     HTTP/1.1 500 Internal Server Error
     *     {
     *         status: 500,
     *         developerMessage: "Required query parameter XXXXX not specified (org.mule.module.apikit.exception.InvalidQueryParameterException).",
     *         userMessage: "Servicio no disponible. Por favor, intente nuevamente más tarde. Muchas gracias.",
     *         errorCode: "",
     *         moreInfo: ""
     *     }
     */
    public function index() {
        $this->directResponse = true;

        $this->queryStringParams['client_id'] = GCBA_API_TRANSPORTE_CLIENT_ID;
        $this->queryStringParams['client_secret'] = GCBA_API_TRANSPORTE_CLIENT_SECRET;

        /**
         * Si no se setea el mes y el año, se toma el actual por defecto
         */
        if (!isset($this->queryStringParams['month'])){
            $this->queryStringParams['month'] = date('Y-m');
        }
        

        $cacheName = $this->generateCacheName();

        if ((!$this->cacheEnabled ) || ($data = Cache::read($cacheName)) === false) {
            $response = $this->http->get('/eventos', $this->queryStringParams);
            $this->httpStatusCode = $response->code;
            $json = $response->json;

            if ( $response->isOk() ){
                $json = $this->processEntity($json);
                $this->setIndexResponse($json);
            }else{
                $this->directResponse = false;
                $this->responseFormat['userMessage'] = 'Servicio no disponible. Por favor, intente nuevamente más tarde. Muchas gracias.';
                $this->responseFormat['developerMessage'] = isset($json['error']) ? $json['error'] : '';
                $this->renderError();
            }
        } else {
            $data = json_decode($data, true);
            $this->apiResponse = $data['apiResponse'];
            $this->httpStatusCode = (int) $data['httpStatusCode'];
            $this->responseFormat['userMessage'] = $data['responseFormat']['userMessage'];
        }
    }

    protected function processEntity($json){
        $response = $json;
        if ( isset($json['list']) ){
            $response = $json['list'];
        }
        return $response;
    }

}
