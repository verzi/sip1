<?php

namespace Colectivos\Controller;

use Colectivos\Controller\ApiController;
use Cake\Cache\Cache;

class ServiceAlertsController extends ApiController {

    // protected $paginationLimit = 50;
    // protected $paginationOffset = 0;

    protected $cacheEnabled = true;

    protected $serviceAlertCauses = [
        "1" => [
            "original" => "UNKNOWN_CAUSE",
            "translation" => "Causa desconocida",
        ],
        "2" => [
            "original" => "OTHER_CAUSE",
            "translation" => "Otra causa",
        ],
        "3" => [
            "original" => "TECHNICAL_PROBLEM",
            "translation" => "Problemas técnicos",
        ],
        "4" => [
            "original" => "STRIKE",
            "translation" => "Corte",
        ],
        "5" => [
            "original" => "DEMONSTRATION",
            "translation" => "Manifestación",
        ],
        "6" => [
            "original" => "ACCIDENT",
            "translation" => "Accidente",
        ],
        "7" => [
            "original" => "HOLIDAY",
            "translation" => "Festividad",
        ],
        "8" => [
            "original" => "WEATHER",
            "translation" => "Clima",
        ],
        "9" => [
            "original" => "MAINTENANCE",
            "translation" => "Mantenimiento",
        ],
        "10" => [
            "original" =>"CONSTRUCTION",
            "translation" => "Construcción",
        ],
        "11" => [
            "original" =>"POLICE_ACTIVITY",
            "translation" => "Actividad policial",
        ],
        "12" => [
            "original" =>"MEDICAL_EMERGENCY",
            "translation" => "Emergencia médica",
        ],
    ];

    protected $serviceAlertEffects = [
        "1" => [
            "original" => "NO_SERVICE",
            "translation" => "Sin servicio",
            "color" => "rojo"
        ],
        "2" => [
            "original" => "REDUCED_SERVICE",
            "translation" => "Servicio reducido",
            "color" => "amarillo"
        ],
        "3" => [
            "original" => "SIGNIFICANT_DELAYS",
            "translation" => "Demoras significativas",
            "color" => "#F2994A"
        ],
        "4" => [
            "original" => "DETOUR",
            "translation" => "Desvicación",
            "color" => "amarillo"
        ],
        "5" => [
            "original" => "ADDITIONAL_SERVICE",
            "translation" => "Servicio adicional",
            "color" => "#27AE60"
        ],
        "6" => [
            "original" => "MODIFIED_SERVICE",
            "translation" => "Modificación en servicio",
            "color" => "amarillo"
        ],
        "7" => [
            "original" => "OTHER_EFFECT",
            "translation" => "Otro efecto",
            "color" => "amarillo"
        ],
        "8" => [
            "original" => "UNKNOWN_EFFECT",
            "translation" => "Efecto desconocido",
            "color" => "amarillo"
        ],
        "9" => [
            "original" => "STOP_MOVED",
            "translation" => "Servicio suspendido",
            "color" => "rojo"
        ],
    ];


    public function initialize() {
        parent::initialize();
    }

    /**
     * @api {get} /colectivos/api/v1.0/service-alerts Service Alerts
     * @apiVersion 1.0.0
     * @apiName IndexColectivos
     * @apiGroup Colectivos
     *
     * @apiDescription Retorna las alertas de servicio de colectivos.<br/> 
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
     * @apiParam (Query string) {String} [agency_id] ID de empresa.
     *
     * ```
     * ?agency_id=145
     * ```
     *
     * @apiParam (Query string) {String} [route_id] ID de la línea.
     *
     * ```
     * ?route_id=39C
     * ```
     * 
     * @apiParam (Query string) {String} [trip] ID del trip.
     *
     * ```
     * ?trip=1013
     * ```
     * 
     * @apiExample Ejemplo de uso:
     *  GET /colectivos/api/v1.0/service-alerts HTTP/1.1
     *  Host: sip1.verzi.com.ar
     *  Cache-Control: no-cache
     *
     * @apiSuccessExample {json} Success-Response:
     * GET 'http://sip1.verzi.com.ar/colectivos/api/v1.0/service-alerts?offset=0&limit=1'
     * HTTP/1.1 200 Ok
     * 
     * {
     *       "metadata":{
     *           "resultset":{
     *               "count":1,
     *               "offset":0,
     *               "limit":1
     *           }
     *       },
     *       "results":[
     *           {
     *               "_alert":{
     *                   "_active_period":[
     *
     *                   ],
     *                   "_cause":2,
     *                   "_description_text":{
     *                   "_translation":[
     *                       {
     *                           "_language":"",
     *                           "_text":"Todas las líneas de AMBA estarán pronto en la app. +info argentina.gob.ar/CuandoSUBO",
     *                           "extensionObject":null
     *                       }
     *                   ],
     *                   "extensionObject":null
     *                   },
     *                   "_effect":8,
     *                   "_header_text":{
     *                   "_translation":[
     *                       {
     *                           "_language":"",
     *                           "_text":"Línea 174 pronto en la app",
     *                           "extensionObject":null
     *                       }
     *                   ],
     *                   "extensionObject":null
     *                   },
     *                   "_url":{
     *                   "_translation":[
     *
     *                   ],
     *                   "extensionObject":null
     *                   },
     *                   "extensionObject":null,
     *                   "_cause_original_text":"OTHER_CAUSE",
     *                   "_cause_translation_text":"Otra causa",
     *                   "_effect_original_text":"UNKNOWN_EFFECT",
     *                   "_effect_translation_text":"Efecto desconocido"
     *               },
     *               "_id":"25",
     *               "_is_deleted":false,
     *               "_trip_update":null,
     *               "_vehicle":null,
     *               "extensionObject":null
     *           }
     *       ]
     *   }
     *
     * @apiSampleRequest http://sip1.verzi.com.ar/colectivos/api/v1.0/service-alerts
     * @apiError Error   Posible error.
     *
     * @apiErrorExample Response (ejemplo):
     *     HTTP/1.1 500 Internal Server Error
     *     {
     *         status: 500,
     *         developerMessage: "Required query parameter provider not specified (org.mule.module.apikit.exception.InvalidQueryParameterException).",
     *         userMessage: "Servicio no disponible. Por favor, intente nuevamente más tarde. Muchas gracias.",
     *         errorCode: "",
     *         moreInfo: ""
     *     }
     */
    public function index() {
        $this->directResponse = true;

        $this->queryStringParams["json"] = '1';
        $this->queryStringParams['client_id'] = GCBA_API_TRANSPORTE_CLIENT_ID;
        $this->queryStringParams['client_secret'] = GCBA_API_TRANSPORTE_CLIENT_SECRET;

        $cacheName = $this->generateCacheName();

        if ((!$this->cacheEnabled ) || ($data = Cache::read($cacheName)) === false) {
            $response = $this->http->get('/serviceAlerts', $this->queryStringParams);
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
        if ( isset($json['_entity']) ){
            $response = $json['_entity'];
            $responseCount = count($response);
            for ($i=0; $i<$responseCount; $i++ ){
                if (isset( $response[$i]['_alert'])){
                    $response[$i]['_alert']['_cause_original_text'] = $this->serviceAlertCauses[$response[$i]['_alert']['_cause']]['original'];
                    $response[$i]['_alert']['_cause_translation_text'] = $this->serviceAlertCauses[$response[$i]['_alert']['_cause']]['translation'];
                    $response[$i]['_alert']['_effect_original_text'] = $this->serviceAlertEffects[$response[$i]['_alert']['_effect']]['original'];
                    $response[$i]['_alert']['_effect_translation_text'] = $this->serviceAlertEffects[$response[$i]['_alert']['_effect']]['translation'];
                    if (isset($response[$i]['_alert']['_informed_entity'])){
                        unset($response[$i]['_alert']['_informed_entity']);
                    }
                }
            }
        }
        return $response;
    }

}
