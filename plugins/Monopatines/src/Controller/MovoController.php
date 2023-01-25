<?php

namespace Monopatines\Controller;

use Monopatines\Controller\ApiController;
use Cake\Network\Http\Client;
use Cake\Cache\Cache;

class MovoController extends ApiController {

    // protected $paginationLimit = 50;
    // protected $paginationOffset = 0;

    protected $cacheEnabled = false;


    public function initialize() {
        parent::initialize();
    }

    /**
     * @api {get} /monopatines/api/v1.0/movo Movo
     * @apiVersion 1.0.0
     * @apiName IndexMovo
     * @apiGroup Monopatines
     *
     * @apiDescription Retorna los monopatines de la empresa Movo.<br/> 
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
     * @apiExample Ejemplo de uso:
     *  GET /monopatines/api/v1.0/movo HTTP/1.1
     *  Host: sip1.verzi.com.ar
     *  Cache-Control: no-cache
     *
     * @apiSuccessExample {json} Success-Response:
     * GET 'http://sip1.verzi.com.ar/monopatines/api/v1.0/movo?offset=0&limit=1'
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
     *               "bike_id":"M#AA2401",
     *               "lat":-34.5871423333333,
     *               "lon":-58.4103471666667,
     *               "is_reserved":0,
     *               "is_disabled":1
     *           }
     *       ]
     *   }
     *
     * @apiSampleRequest http://sip1.verzi.com.ar/monopatines/api/v1.0/movo
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

        $cacheName = $this->generateCacheName();

        if ((!$this->cacheEnabled ) || ($data = Cache::read($cacheName)) === false) {
            $response = $this->http->get('/movo', $this->queryStringParams);
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
        if ( isset($json['data']) && isset($json['data']['bikes']) ){
            $response = $json['data']['bikes'];
        }
        return $response;
    }

}
