<?php

namespace Subtes\Controller;

use Subtes\Controller\ApiController;
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
        ],
        "2" => [
            "original" => "REDUCED_SERVICE",
            "translation" => "Servicio reducido",
        ],
        "3" => [
            "original" => "SIGNIFICANT_DELAYS",
            "translation" => "Demoras significativas",
        ],
        "4" => [
            "original" => "DETOUR",
            "translation" => "Desvicación",
        ],
        "5" => [
            "original" => "ADDITIONAL_SERVICE",
            "translation" => "Servicio adicional",
        ],
        "6" => [
            "original" => "MODIFIED_SERVICE",
            "translation" => "Modificación en servicio",
        ],
        "7" => [
            "original" => "OTHER_EFFECT",
            "translation" => "Otro efecto",
        ],
        "8" => [
            "original" => "UNKNOWN_EFFECT",
            "translation" => "Efecto desconocido",
        ],
        "9" => [
            "original" => "STOP_MOVED",
            "translation" => "Servicio suspendido",
        ],
    ];

    protected $serviceAlertMockData = array (
        0 => 
        array (
          'id' => 'Alert_LineaA',
          'is_deleted' => false,
          'trip_update' => NULL,
          'vehicle' => NULL,
          'alert' => 
          array (
            'active_period' => 
            array (
            ),
            'informed_entity' => 
            array (
              0 => 
              array (
                'agency_id' => '',
                'route_id' => 'LineaA',
                'route_type' => 0,
                'trip' => NULL,
                'stop_id' => '',
              ),
            ),
            'cause' => 12,
            'effect' => 6,
            'url' => NULL,
            'header_text' => 
            array (
              'translation' => 
              array (
                0 => 
                array (
                  'text' => 'Por protocolo de prevención: circula con un servicio especial. Info www.metrovias.com.ar',
                  'language' => 'es',
                ),
              ),
            ),
            'description_text' => 
            array (
              'translation' => 
              array (
                0 => 
                array (
                  'text' => 'Por protocolo de prevención: circula con un servicio especial. Info www.metrovias.com.ar',
                  'language' => 'es',
                ),
              ),
            ),
            'cause_original_text' => 'MEDICAL_EMERGENCY',
            'cause_translation_text' => 'Emergencia médica',
            'effect_original_text' => 'MODIFIED_SERVICE',
            'effect_translation_text' => 'Modificación en servicio',
          ),
        ),
        1 => 
        array (
          'id' => 'Alert_LineaB',
          'is_deleted' => false,
          'trip_update' => NULL,
          'vehicle' => NULL,
          'alert' => 
          array (
            'active_period' => 
            array (
            ),
            'informed_entity' => 
            array (
              0 => 
              array (
                'agency_id' => '',
                'route_id' => 'LineaB',
                'route_type' => 0,
                'trip' => NULL,
                'stop_id' => '',
              ),
            ),
            'cause' => 12,
            'effect' => 6,
            'url' => NULL,
            'header_text' => 
            array (
              'translation' => 
              array (
                0 => 
                array (
                  'text' => 'Por protocolo de prevención: circula con un servicio especial. Info www.metrovias.com.ar',
                  'language' => 'es',
                ),
              ),
            ),
            'description_text' => 
            array (
              'translation' => 
              array (
                0 => 
                array (
                  'text' => 'Por protocolo de prevención: circula con un servicio especial. Info www.metrovias.com.ar',
                  'language' => 'es',
                ),
              ),
            ),
            'cause_original_text' => 'MEDICAL_EMERGENCY',
            'cause_translation_text' => 'Emergencia médica',
            'effect_original_text' => 'MODIFIED_SERVICE',
            'effect_translation_text' => 'Modificación en servicio',
          ),
        ),
        2 => 
        array (
          'id' => 'Alert_LineaC',
          'is_deleted' => false,
          'trip_update' => NULL,
          'vehicle' => NULL,
          'alert' => 
          array (
            'active_period' => 
            array (
            ),
            'informed_entity' => 
            array (
              0 => 
              array (
                'agency_id' => '',
                'route_id' => 'LineaC',
                'route_type' => 0,
                'trip' => NULL,
                'stop_id' => '',
              ),
            ),
            'cause' => 12,
            'effect' => 6,
            'url' => NULL,
            'header_text' => 
            array (
              'translation' => 
              array (
                0 => 
                array (
                  'text' => 'Por protocolo de prevención: circula con un servicio especial. Info www.metrovias.com.ar',
                  'language' => 'es',
                ),
              ),
            ),
            'description_text' => 
            array (
              'translation' => 
              array (
                0 => 
                array (
                  'text' => 'Por protocolo de prevención: circula con un servicio especial. Info www.metrovias.com.ar',
                  'language' => 'es',
                ),
              ),
            ),
            'cause_original_text' => 'MEDICAL_EMERGENCY',
            'cause_translation_text' => 'Emergencia médica',
            'effect_original_text' => 'MODIFIED_SERVICE',
            'effect_translation_text' => 'Modificación en servicio',
          ),
        ),
        3 => 
        array (
          'id' => 'Alert_LineaD',
          'is_deleted' => false,
          'trip_update' => NULL,
          'vehicle' => NULL,
          'alert' => 
          array (
            'active_period' => 
            array (
            ),
            'informed_entity' => 
            array (
              0 => 
              array (
                'agency_id' => '',
                'route_id' => 'LineaD',
                'route_type' => 0,
                'trip' => NULL,
                'stop_id' => '',
              ),
            ),
            'cause' => 12,
            'effect' => 6,
            'url' => NULL,
            'header_text' => 
            array (
              'translation' => 
              array (
                0 => 
                array (
                  'text' => 'Por protocolo de prevención: circula con un servicio especial. Info www.metrovias.com.ar',
                  'language' => 'es',
                ),
              ),
            ),
            'description_text' => 
            array (
              'translation' => 
              array (
                0 => 
                array (
                  'text' => 'Por protocolo de prevención: circula con un servicio especial. Info www.metrovias.com.ar',
                  'language' => 'es',
                ),
              ),
            ),
            'cause_original_text' => 'MEDICAL_EMERGENCY',
            'cause_translation_text' => 'Emergencia médica',
            'effect_original_text' => 'MODIFIED_SERVICE',
            'effect_translation_text' => 'Modificación en servicio',
          ),
        ),
        4 => 
        array (
          'id' => 'Alert_LineaE',
          'is_deleted' => false,
          'trip_update' => NULL,
          'vehicle' => NULL,
          'alert' => 
          array (
            'active_period' => 
            array (
            ),
            'informed_entity' => 
            array (
              0 => 
              array (
                'agency_id' => '',
                'route_id' => 'LineaE',
                'route_type' => 0,
                'trip' => NULL,
                'stop_id' => '',
              ),
            ),
            'cause' => 12,
            'effect' => 6,
            'url' => NULL,
            'header_text' => 
            array (
              'translation' => 
              array (
                0 => 
                array (
                  'text' => 'Por protocolo de prevención: circula con un servicio especial. Info www.metrovias.com.ar',
                  'language' => 'es',
                ),
              ),
            ),
            'description_text' => 
            array (
              'translation' => 
              array (
                0 => 
                array (
                  'text' => 'Por protocolo de prevención: circula con un servicio especial. Info www.metrovias.com.ar',
                  'language' => 'es',
                ),
              ),
            ),
            'cause_original_text' => 'MEDICAL_EMERGENCY',
            'cause_translation_text' => 'Emergencia médica',
            'effect_original_text' => 'MODIFIED_SERVICE',
            'effect_translation_text' => 'Modificación en servicio',
          ),
        ),
        5 => 
        array (
          'id' => 'Alert_LineaH',
          'is_deleted' => false,
          'trip_update' => NULL,
          'vehicle' => NULL,
          'alert' => 
          array (
            'active_period' => 
            array (
            ),
            'informed_entity' => 
            array (
              0 => 
              array (
                'agency_id' => '',
                'route_id' => 'LineaH',
                'route_type' => 0,
                'trip' => NULL,
                'stop_id' => '',
              ),
            ),
            'cause' => 12,
            'effect' => 6,
            'url' => NULL,
            'header_text' => 
            array (
              'translation' => 
              array (
                0 => 
                array (
                  'text' => 'Por protocolo de prevención: circula con un servicio especial. Info www.metrovias.com.ar',
                  'language' => 'es',
                ),
              ),
            ),
            'description_text' => 
            array (
              'translation' => 
              array (
                0 => 
                array (
                  'text' => 'Por protocolo de prevención: circula con un servicio especial. Info www.metrovias.com.ar',
                  'language' => 'es',
                ),
              ),
            ),
            'cause_original_text' => 'MEDICAL_EMERGENCY',
            'cause_translation_text' => 'Emergencia médica',
            'effect_original_text' => 'MODIFIED_SERVICE',
            'effect_translation_text' => 'Modificación en servicio',
          ),
        ),
    );

    public function initialize() {
        parent::initialize();
    }

    /**
     * @api {get} /subtes/api/v1.0/service-alerts Service Alerts
     * @apiVersion 1.0.0
     * @apiName IndexSubtes
     * @apiGroup Subtes
     *
     * @apiDescription Retorna las alertas de servicio de subtes.<br/> 
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
     *  GET /subtes/api/v1.0/service-alerts HTTP/1.1
     *  Host: sip1.verzi.com.ar
     *  Cache-Control: no-cache
     *
     * @apiSuccessExample {json} Success-Response:
     * GET 'http://sip1.verzi.com.ar/subtes/api/v1.0/service-alerts?offset=0&limit=1'
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
     *               "id":"Alert_LineaA",
     *               "is_deleted":false,
     *               "trip_update":null,
     *               "vehicle":null,
     *               "alert":{
     *                   "active_period":[
     *
     *                   ],
     *                   "informed_entity":[
     *                   {
     *                       "agency_id":"",
     *                       "route_id":"LineaA",
     *                       "route_type":0,
     *                       "trip":null,
     *                       "stop_id":""
     *                   }
     *                   ],
     *                   "cause":12,
     *                   "effect":6,
     *                   "url":null,
     *                   "header_text":{
     *                   "translation":[
     *                       {
     *                           "text":"Por protocolo de prevención: circula con un servicio especial. Info www.metrovias.com.ar",
     *                           "language":"es"
     *                       }
     *                   ]
     *                   },
     *                   "description_text":{
     *                   "translation":[
     *                       {
     *                           "text":"Por protocolo de prevención: circula con un servicio especial. Info www.metrovias.com.ar",
     *                           "language":"es"
     *                       }
     *                   ]
     *                   },
     *                   "cause_original_text":"MEDICAL_EMERGENCY",
     *                   "cause_translation_text":"Emergencia médica",
     *                   "effect_original_text":"MODIFIED_SERVICE",
     *                   "effect_translation_text":"Modificación en servicio"
     *               }
     *           }
     *       ]
     *   }
     *
     * @apiSampleRequest http://sip1.verzi.com.ar/subtes/api/v1.0/service-alerts
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

        $this->queryStringParams["json"] = '1';
        $this->queryStringParams['client_id'] = GCBA_API_TRANSPORTE_CLIENT_ID;
        $this->queryStringParams['client_secret'] = GCBA_API_TRANSPORTE_CLIENT_SECRET;

        $cacheName = $this->generateCacheName();

        /**
         * Mock
         */
        if (isset($this->queryStringParams['_mock'])){
            return $this->setIndexResponse($this->serviceAlertMockData);
        }

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
        if ( isset($json['entity']) ){
            $response = $json['entity'];
            $responseCount = count($response);
            for ($i=0; $i<$responseCount; $i++ ){
                if (isset( $response[$i]['alert'])){
                    $response[$i]['alert']['cause_original_text'] = $this->serviceAlertCauses[$response[$i]['alert']['cause']]['original'];
                    $response[$i]['alert']['cause_translation_text'] = $this->serviceAlertCauses[$response[$i]['alert']['cause']]['translation'];
                    $response[$i]['alert']['effect_original_text'] = $this->serviceAlertEffects[$response[$i]['alert']['effect']]['original'];
                    $response[$i]['alert']['effect_translation_text'] = $this->serviceAlertEffects[$response[$i]['alert']['effect']]['translation'];
                }
            }
        }
        return $response;
    }

}
