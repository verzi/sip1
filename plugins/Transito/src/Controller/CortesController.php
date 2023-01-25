<?php

namespace Transito\Controller;

use Transito\Controller\ApiController;
use Cake\Cache\Cache;
use Cake\Network\Http\Client;
class CortesController extends ApiController {

    // protected $paginationLimit = 50;
    // protected $paginationOffset = 0;

    protected $cacheEnabled = true;

    protected $googleMapsKey = "AIzaSyCNZr4MuwLAnmvLH9wvf-ZOQvO0DanzRz4"; //"AIzaSyD1jbj6Tuf2xoWs4DjOc2kSfBTt6pVJO2s"

    /**
     * indicates that no errors occurred; the address was successfully parsed and at least one geocode was returned.
     */
    const GOOGLE_MAPS_API_GEOCODE_STATUS_CODE_OK = "OK";
    /**
     * indicates that the geocode was successful but returned no results. This may occur if the geocoder was passed a non-existent address.
     */
    const GOOGLE_MAPS_API_GEOCODE_STATUS_CODE_ZERO_RESULTS = "ZERO_RESULTS";
    /**
     * indicates any of the following:
     *   - The API key is missing or invalid.
     *   - Billing has not been enabled on your account.
     *   - A self-imposed usage cap has been exceeded.
     *   - The provided method of payment is no longer valid (for example, a credit card has expired).
     *   - See the Maps FAQ to learn how to fix this.
     */
    const GOOGLE_MAPS_API_GEOCODE_STATUS_CODE_OVER_DAILY_LIMIT = "OVER_DAILY_LIMIT";
    /**
     * indicates that you are over your quota.
     */
    const GOOGLE_MAPS_API_GEOCODE_STATUS_CODE_OVER_QUERY_LIMIT = "OVER_QUERY_LIMIT";
    /**
     * indicates that your request was denied.
     */
    const GOOGLE_MAPS_API_GEOCODE_STATUS_CODE_REQUEST_DENIED = "REQUEST_DENIED";
    /**
     * generally indicates that the query (address, components or latlng) is missing.
     */
    const GOOGLE_MAPS_API_GEOCODE_STATUS_CODE_INVALID_REQUEST = "INVALID_REQUEST";
    /**
     * indicates that the request could not be processed due to a server error. The request may succeed if you try again.
     */
    const GOOGLE_MAPS_API_GEOCODE_STATUS_CODE_UNKNOWN_ERROR = "UNKNOWN_ERROR";


    public function initialize() {
        parent::initialize();
    }

    /**
     * @api {get} /transito/api/v1.0/cortes Cortes
     * @apiVersion 1.0.0
     * @apiName IndexCortes
     * @apiGroup Transito
     *
     * @apiDescription Retorna los cortes de tránsito.<br/> 
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
     *  GET /transito/api/v1.0/cortes HTTP/1.1
     *  Host: sip1.verzi.com.ar
     *  Cache-Control: no-cache
     *
     * @apiSuccessExample {json} Success-Response:
     * GET 'http://sip1.verzi.com.ar/transito/api/v1.0/cortes?offset=0&limit=1'
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
     *               "id":"batransito-2197397-Closure-522",
     *               "parent_event":"batransito-2197397",
     *               "type":"ROAD_CLOSED",
     *               "description":"Buenos Aires: Debido a Otros en Area 1 en TTE.GENERAL JUAN DOMINGO PERON (E) en AV. CALLAO (batransito)",
     *               "location":{
     *                   "street":"Av. Callao",
     *                   "polyline":"-34.606788635253906 -58.39211654663086 -34.60663986206055 -58.39212417602539 -34.605648040771484 -58.39219665527344 ",
     *                   "direction":"ONE_DIRECTION",
     *                   "polyline_coordinates":[
     *                   {
     *                       "lat":"-34.606788635253906",
     *                       "lon":"-58.39211654663086",
     *                       "address":"Av. Callao 186, C1022AAO CABA, Argentina"
     *                   },
     *                   {
     *                       "lat":"-34.60663986206055",
     *                       "lon":"-58.39212417602539",
     *                       "address":"Av. Callao 200, C1022AAP CABA, Argentina"
     *                   },
     *                   {
     *                       "lat":"-34.605648040771484",
     *                       "lon":"-58.39219665527344",
     *                       "address":"Avenida Callao, Sarmiento &, C1025 CABA, Argentina"
     *                   }
     *                   ]
     *               },
     *               "reference":"batransito",
     *               "creationtime":"2020-04-17T17:19:54-03:00",
     *               "updatetime":"2020-04-17T21:27:04-03:00",
     *               "starttime":"2020-04-17T17:19:54-03:00",
     *               "endtime":"2020-04-18T17:19:54-03:00"
     *           }
     *       ]
     *   }
     *
     * @apiSampleRequest http://sip1.verzi.com.ar/transito/api/v1.0/cortes
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

         /**
         * Mock
         */
        if (isset($this->queryStringParams['_mock'])){
            $mock = array (
                  0 => 
                  array (
                    'id' => 'batransito-2197397-Closure-522',
                    'parent_event' => 'batransito-2197397',
                    'type' => 'ROAD_CLOSED',
                    'description' => 'Debido a Otros en Area 1 en TTE.GENERAL JUAN DOMINGO PERON (E) en AV. CALLAO (batransito)',
                    'location' => 
                    array (
                      'street' => 'Av. Callao',
                      'polyline' => '-34.606788635253906 -58.39211654663086 -34.60663986206055 -58.39212417602539 -34.605648040771484 -58.39219665527344 ',
                      'direction' => 'ONE_DIRECTION',
                      'polyline_coordinates' => 
                      array (
                        0 => 
                        array (
                          'lat' => '-34.606788635253906',
                          'lon' => '-58.39211654663086',
                          'fullAddress' => 'Av. Callao 186, C1022AAO CABA, Argentina',
                          'shortAddress' => 'Av. Callao 186',
                        ),
                        1 => 
                        array (
                          'lat' => '-34.60663986206055',
                          'lon' => '-58.39212417602539',
                          'fullAddress' => 'Av. Callao 200, C1022AAP CABA, Argentina',
                          'shortAddress' => 'Av. Callao 200',
                        ),
                        2 => 
                        array (
                          'lat' => '-34.605648040771484',
                          'lon' => '-58.39219665527344',
                          'fullAddress' => 'Avenida Callao, Sarmiento &, C1025 CABA, Argentina',
                          'shortAddress' => 'Avenida Callao y Sarmiento',
                        ),
                      ),
                    ),
                    'reference' => 'batransito',
                    'creationtime' => '2020-06-16T17:19:54-03:00',
                    'updatetime' => '2020-06-16T21:27:04-03:00',
                    'starttime' => '2020-06-17T00:19:54-03:00',
                    'endtime' => '2021-06-17T23:50:54-03:00',
                  ),
                  1 => 
                  array (
                    'id' => 'batransito-2197397-Closure-523',
                    'parent_event' => 'batransito-2197398',
                    'type' => 'ROAD_CLOSED',
                    'description' => 'Debido a Obras en calzada',
                    'location' => 
                    array (
                      'street' => 'Av. Callao',
                      'polyline' => '-34.606788635253906 -58.39211654663086 -34.60663986206055 -58.39212417602539 -34.605648040771484 -58.39219665527344 ',
                      'direction' => 'ONE_DIRECTION',
                      'polyline_coordinates' => 
                      array (
                        0 => 
                        array (
                          'lat' => '-34.606788635253906',
                          'lon' => '-58.39211654663086',
                          'fullAddress' => 'Av. Callao 186, C1022AAO CABA, Argentina',
                          'shortAddress' => 'Av. Callao 186',
                        ),
                        1 => 
                        array (
                          'lat' => '-34.60663986206055',
                          'lon' => '-58.39212417602539',
                          'fullAddress' => 'Av. Callao 200, C1022AAP CABA, Argentina',
                          'shortAddress' => 'Av. Callao 200',
                        ),
                        2 => 
                        array (
                          'lat' => '-34.605648040771484',
                          'lon' => '-58.39219665527344',
                          'fullAddress' => 'Avenida Callao, Sarmiento &, C1025 CABA, Argentina',
                          'shortAddress' => 'Avenida Callao y Sarmiento',
                        ),
                      ),
                    ),
                    'reference' => 'batransito',
                    'creationtime' => '2020-04-17T17:19:54-03:00',
                    'updatetime' => '2020-04-17T21:27:04-03:00',
                    'starttime' => '2020-06-17T09:25:28-03:00',
                    'endtime' => '2020-06-17T23:58:00-03:00',
                  ),
                  2 => [
                    'id' => '260507',
                    'type' => 'ROAD_CLOSED',
                    'subtype' => 'ROAD_CLOSED_CONSTRUCTION',
                    'location' => [
                      'street' => 'Talcahuano',
                      'polyline' => '-34.598303 -58.385562 -34.600529 -58.385401',
                      'direction' => 'ONE_DIRECTION',
                      'polyline_coordinates' => [
                        (int) 0 => [
                          'lat' => '-34.598303',
                          'lon' => '-58.385562',
                          'fullAddress' => 'Talcahuano 800, C1048 CABA, Argentina',
                          'shortAddress' => 'Talcahuano 800'
                        ],
                        (int) 1 => [
                          'lat' => '-34.600529',
                          'lon' => '-58.385401',
                          'fullAddress' => 'Talcahuano 700, C1048 CABA, Argentina',
                          'shortAddress' => 'Talcahuano 700'
                        ],
                      ]
                    ],
                    'starttime' => '2020-06-15T09:25:28-03:00',
                    'endtime' => '2020-06-19T23:58:00-03:00',
                    'description' => 'Debido a Obras en calzada en Uruguay (S) entre  Lavalle y  Avenida Corrientes (batransito)',
                    'schedule' => '',
                    'reference' => 'batransito'
                  ],
                  3 => [
                    'id' => '277053',
                    'type' => 'ROAD_CLOSED',
                    'location' => [
                      'street' => 'Cerrito',
                      'polyline' => '-34.601412 -58.382429 -34.602577 -58.382375',
                      'direction' => 'ONE_DIRECTION',
                      'polyline_coordinates' => [
                        (int) 0 => [
                          'lat' => '-34.601412',
                          'lon' => '-58.382429',
                          'fullAddress' => 'Cerrito 600, C1012AAD CABA, Argentina',
                          'shortAddress' => 'Cerrito 600'
                        ],
                        (int) 1 => [
                          'lat' => '-34.602577',
                          'lon' => '-58.382375',
                          'fullAddress' => 'Cerrito 500, C1012AAD CABA, Argentina',
                          'shortAddress' => 'Cerrito 500'
                        ],
                      ]
                    ],
                    'starttime' => '2019-06-15T14:37:00-03:00',
                    'endtime' => '2019-06-19T14:37:00-03:00',
                    'description' => 'CORTE TOTAL(batransito)',
                    'reference' => 'batransito'
                  ]
            );
            return $this->setIndexResponse($mock);
        }

        if ((!$this->cacheEnabled ) || ($data = Cache::read($cacheName)) === false) {
            $response = $this->http->get('/cortes', $this->queryStringParams);
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
        if ( isset($json['incidents']) ){
            $response = $json['incidents'];
            $responseCount = count($response);
            for ($i=0; $i<$responseCount; $i++ ){
                
                if ( isset($response[$i]['description'])){
                  $response[$i]['description'] = str_replace('Buenos Aires:','', $response[$i]['description']);
                }

                $coordinatesCacheName = md5($response[$i]['id']);

                if (($data = Cache::read($coordinatesCacheName, 'yearly')) === false) {
                    if ( isset($response[$i]['location']) && isset($response[$i]['location']['polyline']) ){
                        $response[$i]['location']["polyline_coordinates"] = [];
                        $polyline = explode(" ", trim($response[$i]['location']['polyline']));
                        $polyline = array_chunk($polyline, 2); 
                        for ($j=0; $j<count($polyline); $j++){
                            
                            $googleMapsResponse = $this->http->get('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($polyline[$j][0]).','.trim($polyline[$j][1]).'&key='.$this->googleMapsKey);
                            
                            $googleMapsJsonResponse = [];

                            if ( $googleMapsResponse->isOk() ){
                                $googleMapsJsonResponse = $googleMapsResponse->json;
                            }

                            $formattedAddress = "";

                            if ( !isset($googleMapsJsonResponse['status']) || (isset($googleMapsJsonResponse['status']) &&  $googleMapsJsonResponse['status'] !== self::GOOGLE_MAPS_API_GEOCODE_STATUS_CODE_OK ) ){
                              return $formattedAddress;
                            }

                            if ( isset($googleMapsJsonResponse['results'][0]['formatted_address']) ){
                                $formattedAddress = $googleMapsJsonResponse['results'][0]['formatted_address'];
                            }

                            $response[$i]['location']["polyline_coordinates"][] = [
                                "lat" => $polyline[$j][0], 
                                "lon" => $polyline[$j][1],
                                "fullAddress" => $formattedAddress,
                                "shortAddress" => $this->getShortAddress($formattedAddress)
                            ];
                        }
                        Cache::write($coordinatesCacheName, json_encode($response[$i]['location']["polyline_coordinates"], true), 'yearly');
                    }
                } else {
                    $data = json_decode($data, true);
                    $response[$i]['location']["polyline_coordinates"] = $data;
                }
            }
        }
        return $response;
    }

    private function getShortAddress($formattedAddress){
      $shortAddress = $formattedAddress;
      $shortAddressParts = explode(',', $shortAddress);
      if (isset($shortAddressParts[1]) && mb_substr($shortAddressParts[1], -1) === "&" ){
        $shortAddress = trim($shortAddressParts[0]) . " y ". trim(mb_substr($shortAddressParts[1], 0, (int)(strlen($shortAddressParts[1])-1)));
      }else{
        $shortAddress = trim($shortAddressParts[0]);
      }

      return $shortAddress;
    }

}
