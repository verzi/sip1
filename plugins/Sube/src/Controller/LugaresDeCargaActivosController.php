<?php

namespace Sube\Controller;

use Sube\Controller\ApiController;
use Cake\Network\Http\Client;
use Cake\Cache\Cache;
use Google\Cloud\Firestore\FirestoreClient;

use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\Blob;
//use Google\Cloud\Core\DebugInfoTrait;
use Google\Cloud\Core\GeoPoint;
use Google\Cloud\Core\Int64;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Core\TimeTrait;
//use Google\Cloud\Core\ValidateTrait;
//use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Protobuf\NullValue;

use DateTime;

class LugaresDeCargaActivosController extends ApiController {

    // protected $paginationLimit = 50;
    // protected $paginationOffset = 0;
    
    /**
     * Possible date types value options are:
     */
    
    //    stringValue
    const STRING_DATA_TYPE = "stringValue";
    //    doubleValue
    const DOUBLE_DATA_TYPE = "doubleValue";
    //    integerValue
    const INTEGER_DATA_TYPE = "integerValue";
    //    booleanValue
    const BOOLEAN_DATA_TYPE = "booleanValue";
    //    arrayValue
    const ARRAY_DATA_TYPE = "arrayValue";
    //    bytesValue
    const BYTES_DATA_TYPE = "bytesValue";
    //    geoPointValue
    const GEO_POINT_DATA_TYPE = "geoPointValue";
    //    mapValue
    const MAP_DATA_TYPE = "mapValue";
    //    nullValue
    const NULL_DATA_TYPE = "nullValue";
    //    referenceValue
    const REFERENCE_DATA_TYPE = "referenceValue";
    //    timestampValue
    const TIMESTAMP_DATA_TYPE = "timestampValue";
    
    protected $fileAttributesMapping = [
        'Id Entidad' => [
            'id' => 'id',
            'type' => self::INTEGER_DATA_TYPE,
            'defaultValue' => '',
        ],
		'Entidad' => [
            'id' => 'entidad',
            'type' => self::STRING_DATA_TYPE,
            'defaultValue' => '',
        ],
		'Id Ubicaci' => [
            'id' => 'idUbicacion',
            'type' => self::INTEGER_DATA_TYPE,
            'defaultValue' => '',
        ],
		'Estado' => [
            'id' => 'estado',
            'type' => self::STRING_DATA_TYPE,
            'defaultValue' => '',
        ],
		'Tipo de Ce' =>  [
            'id' => 'tipoServicio',
            'type' => self::STRING_DATA_TYPE,
            'defaultValue' => '',
        ],
		'Ubicacion' =>  [
            'id' => 'ubicacion',
            'type' => self::STRING_DATA_TYPE,
            'defaultValue' => '',
        ],
		'Nro.Cuit' => [
            'id' => 'cuit',
            'type' => self::DOUBLE_DATA_TYPE,
            'defaultValue' => '',
        ],
		'Tipo Ubica' =>  [
            'id' => 'tipoUbicacion',
            'type' => self::STRING_DATA_TYPE,
            'defaultValue' => '',
        ],
		'Modalidad' => [
            'id' => 'modalidad',
            'type' => self::STRING_DATA_TYPE,
            'defaultValue' => '',
        ],
		'Direccion' => [
            'id' => 'direccionCalle',
            'type' => self::STRING_DATA_TYPE,
            'defaultValue' => '',
        ],
		'Numero' => [
            'id' => 'direccionNumero',
            'type' => self::STRING_DATA_TYPE,
            'defaultValue' => '',
        ],
		'Barrio' => [
            'id' => 'barrio',
            'type' => self::STRING_DATA_TYPE,
            'defaultValue' => '',
        ],
		'Comuna' => [
            'id' => 'comuna',
            'type' => self::STRING_DATA_TYPE,
            'defaultValue' => '',
        ],
		'Partido' => [
            'id' => 'partido',
            'type' => self::STRING_DATA_TYPE,
            'defaultValue' => '',
        ],
		'Pais' => [
            'id' => 'pais',
            'type' => self::STRING_DATA_TYPE,
            'defaultValue' => '',
        ],
		'Provincia' => [
            'id' => 'provincia',
            'type' => self::STRING_DATA_TYPE,
            'defaultValue' => '',
        ],
		'Localidad' => [
            'id' => 'localidad',
            'type' => self::STRING_DATA_TYPE,
            'defaultValue' => '',
        ],
		'CP' => [
            'id' => 'cp',
            'type' => self::STRING_DATA_TYPE,
            'defaultValue' => '',
        ],
		'Latitud' => [
            'id' => 'lat',
            'type' => self::GEO_POINT_DATA_TYPE,
            'defaultValue' => '',
            'latitudeAttributeName' => 'Latitud',
            'longitudeAttributeName' => 'Longitud'
        ],
		'Longitud' => [
            'id' => 'lon',
            'type' => self::GEO_POINT_DATA_TYPE,
            'defaultValue' => '',
            'latitudeAttributeName' => 'Latitud',
            'longitudeAttributeName' => 'Longitud'
        ],
    ];


    protected $cacheEnabled = false;


    public function initialize() {
        parent::initialize();
    }

    /**
     * @api {get} /monopatines/api/v1.0/glovo Glovo
     * @apiVersion 1.0.0
     * @apiName IndexGlovo
     * @apiGroup Monopatines
     *
     * @apiDescription Retorna los monopatines de la empresa Glovo.<br/> 
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
     *  GET /monopatines/api/v1.0/glovo HTTP/1.1
     *  Host: sip1.verzi.com.ar
     *  Cache-Control: no-cache
     *
     * @apiSuccessExample {json} Success-Response:
     * GET 'http://sip1.verzi.com.ar/monopatines/api/v1.0/glovo?offset=0&limit=1'
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
     *               "bike_id":"G1136",
     *               "lat":-34.5871423333333,
     *               "lon":-58.4103471666667,
     *               "is_reserved":0,
     *               "is_disabled":1
     *           }
     *       ]
     *   }
     *
     * @apiSampleRequest http://sip1.verzi.com.ar/monopatines/api/v1.0/glovo
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
        return;
        $this->directResponse = true;

        $this->queryStringParams['client_id'] = GCBA_API_TRANSPORTE_CLIENT_ID;
        $this->queryStringParams['client_secret'] = GCBA_API_TRANSPORTE_CLIENT_SECRET;

        $cacheName = $this->generateCacheName();

        if ((!$this->cacheEnabled ) || ($data = Cache::read($cacheName)) === false) {
            $response = $this->http->get('/glovo', $this->queryStringParams);
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

    protected function processOriginalSourceEntity($entity){
        $processedEntity = [];
        
        if ( !isset($entity['properties']) ){
            return null;
        }

        foreach($entity['properties'] as $key => $value){
            if (!isset($this->fileAttributesMapping[$key])){
                continue;
            }

            $mappedKey = $this->fileAttributesMapping[$key]['id'];

            switch ($this->fileAttributesMapping[$key]['type']) {
                case self::GEO_POINT_DATA_TYPE:
                    $processedEntity[$mappedKey] = new GeoPoint($entity['properties'][$this->fileAttributesMapping[$key]['latitudeAttributeName']], $entity['properties'][$this->fileAttributesMapping[$key]['longitudeAttributeName']]);
                    break;
                default:
                    $processedEntity[$mappedKey] = $value;       
                    break;
            }
        }

        if (isset($processedEntity['lat']) && isset($processedEntity['lon'])){
            $processedEntity['geo'] = $processedEntity['lat'];
            unset($processedEntity['lat']);
            unset($processedEntity['lon']);
        }

        return $processedEntity;
    }

    public function testing(){
        return;
        $from = 0;

        if ( $this->request->query('from') ){
            $from = (int) $this->request->query('from');
        }

        $fileContent = file_get_contents(TMP.'sube_red_de_carga_activa_2019-10-01.geojson');
        $fileContent = json_decode($fileContent, true);
        $count = count($fileContent['features']);

        $to = $from + 500;
        $continue = true;

        if ($to > $count){
            $to = $count;
            $continue = false;
        }

        //print_r(($to/$count)*100 ."% completado." . PHP_EOL);

        $items = [];
        $item = [];
        $db = new FirestoreClient();
        for($i=$from; $i<$to; $i++){
            $item = $this->processOriginalSourceEntity($fileContent['features'][$i]);
            if (!is_null($item)){
                //$db->collection('sube-lugares-de-carga')->document($item['idUbicacion'])->set($item);
            }
        }
        sleep(2);
        if ($continue){
            return $this->redirect([
                'action' => 'showStatus',
                '?' => [
                    'from' => $to,
                    'to' => $to,
                    'count' => $count,
                ]
            ]);
        }
        exit;
    }

    public function showStatus(){
        $from = $this->request->query('from');
        $to = $this->request->query('to');
        $count= $this->request->query('count');
        print_r(($to/$count)*100 ."% completado." . PHP_EOL);
        $continue = true;
        sleep(3);
        if ($to > $count){
            $to = $count;
            $continue = false;
        }
        if ($continue){
            return $this->redirect([
                'action' => 'testing',
                '?' => [
                    'from' => $to,
                ]
            ]);
        }
        exit;
    }

    public function getDemo(){
        $firestore = new FirestoreClient();
        $collectionReference = $firestore->collection('subways-agencies');
        //$documentReference = $collectionReference->document('3');
        //$snapshot = $documentReference->snapshot();
        $snapshot = $collectionReference->documents();
        $items = [];
        foreach( $snapshot as $id => $subwayAgency){
            debug($subwayAgency);
            debug($subwayAgency->data());
            debug($subwayAgency->updateTime()->formatAsString());
            debug($subwayAgency->path());
            debug($subwayAgency->reference());
            debug($subwayAgency->readTime()->formatAsString());
            debug($subwayAgency->createTime()->formatAsString());
            exit;
            $items[] = $subwayAgency->data();
        }
        $this->setIndexResponse($items);
    }


    public function getRoutes(){
        $firestore = new FirestoreClient();
        $collectionReference = $firestore->collection('users');
        $documentReference = $collectionReference->document('ydaBJRdezbMXPMxSunDUcKzZTRH2/routes/Trabajo');
        $snapshot = $documentReference->snapshot();
        //$snapshot = $collectionReference->documents();
        debug($snapshot);exit;
        $items = [];
        foreach( $snapshot as $id => $subwayAgency){
            debug($subwayAgency);
            debug($subwayAgency->data());
            debug($subwayAgency->updateTime()->formatAsString());
            debug($subwayAgency->path());
            debug($subwayAgency->reference());
            debug($subwayAgency->readTime()->formatAsString());
            debug($subwayAgency->createTime()->formatAsString());
            exit;
            $items[] = $subwayAgency->data();
        }
        $this->setIndexResponse($items);
    }


    public function runSimulation(){
        
        if ( !$this->request->query('userId') ){
            $this->httpStatusCode = 400;
            $this->responseFormat['developerMessage'] = "El parámetro userId es obligatorio";
            $this->responseFormat['userMessage'] = $this->responseFormat['developerMessage'];
            return null;
        }

        if ( !$this->request->query('routeId') ){
            $this->httpStatusCode = 400;
            $this->responseFormat['developerMessage'] = "El parámetro routeId es obligatorio";
            $this->responseFormat['userMessage'] = $this->responseFormat['developerMessage'];
            return null;
        }

        if ( !$this->request->query('routeStatus') ){
            $this->httpStatusCode = 400;
            $this->responseFormat['developerMessage'] = "El parámetro routeStatus es obligatorio";
            $this->responseFormat['userMessage'] = $this->responseFormat['developerMessage'];
            return null;
        }

        if ( !$this->request->query('routeEfficiencyPercent') ){
            $this->httpStatusCode = 400;
            $this->responseFormat['developerMessage'] = "El parámetro routeEfficiencyPercent es obligatorio";
            $this->responseFormat['userMessage'] = $this->responseFormat['developerMessage'];
            return null;
        }

        if ( !$this->request->query('deviceToken') ){
            $this->httpStatusCode = 400;
            $this->responseFormat['developerMessage'] = "El parámetro deviceToken es obligatorio";
            $this->responseFormat['userMessage'] = $this->responseFormat['developerMessage'];
            return null;
        }

        if ( !$this->request->query('notificationTitle') ){
            $this->httpStatusCode = 400;
            $this->responseFormat['developerMessage'] = "El parámetro notificationTitle es obligatorio";
            $this->responseFormat['userMessage'] = $this->responseFormat['developerMessage'];
            return null;
        }

        if ( !$this->request->query('notificationBody') ){
            $this->httpStatusCode = 400;
            $this->responseFormat['developerMessage'] = "El parámetro notificationBody es obligatorio";
            $this->responseFormat['userMessage'] = $this->responseFormat['developerMessage'];
            return null;
        }
        

        // ydaBJRdezbMXPMxSunDUcKzZTRH2
        $userId = $this->request->query('userId');
        
        // Trabajo
        $routeId = $this->request->query('routeId');
        
        $routeEfficiencyPercent = $this->request->query('routeEfficiencyPercent');
        
        $routeStatus = $this->request->query('routeStatus');
        
        // DeT4yxCxIm8ZFATlIcF8CS
        $deviceToken = $this->request->query('deviceToken');
        
        $notificationTitle = $this->request->query('notificationTitle');
        
        $notificationBody = $this->request->query('notificationBody');

        $message = [];

        /**
         * ACTUALIZAMOS LA RUTA
         */
        $firestore = new FirestoreClient();
        $collectionReference = $firestore->collection('users');
        $documentReference = $collectionReference->document($userId . '/routes/' . $routeId);

        $documentReference->update([
            [
                'path' => 'status', 
                'value' => $routeStatus
            ],
            [
                'path' => 'efficiency', 
                'value' => $routeEfficiencyPercent . "%"
            ]
        ]);

        $message[] = "Ruta ".$routeId." actualizada con status: ".$routeStatus." y efficency: ". $routeEfficiencyPercent. "%";

        /**
         * AGREGO LA NOTIFICACION EN FIREBASE
         */        
        $data = [
            'title' => $notificationTitle,
            'message' => $notificationBody,
            'user' => $firestore->collection('users')->document($userId),
            'readAt' => null,
            'sentAt' => new Timestamp(new DateTime()),
            'createdAt' => new Timestamp(new DateTime()),
        ];
        $addedDocRef = $firestore->collection('notifications')->newDocument();
        $firestore->collection('notifications')->document($addedDocRef->id())->set($data);

        $message[] = "Notificación ".$addedDocRef->id()." agregada en la colección notifications";

        /**
         * ENVIO NOTIFICACION PUSH
         */

        $notification = array(
            array(
                "to" => "ExponentPushToken[".$deviceToken."]",
                "title" => $notificationTitle,
                "body" =>  $notificationBody,
                "badge" => 1,
                "data" => array(
                    "title" => $notificationTitle,
                    "body" => $notificationBody
                )
            )
        );

        $httpClient = new Client();

        $response = $httpClient->post(
            'https://exp.host/--/api/v2/push/send',
            json_encode($notification),
            [
                'headers' => [
                    'authority' => "exp.host",
                    'accept' => "application/json",
                    'user-agent' => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36",
                    'content-type' => "application/json",
                    'origin' => "https://expo.io",
                    'sec-fetch-site' => "cross-site",
                    'sec-fetch-mode' => "cors",
                    'sec-fetch-dest' => "empty",
                    'referer' => "https://expo.io/",
                    'accept-language' => "es-ES,es;q=0.9,ru;q=0.8",
                ]
            ]
        );

        if ($response->isOk()){
            $body = json_decode($response->body());
            if (property_exists($body, 'data')){
                $data = $body->data;
                if (!empty($data) && property_exists($data[0], 'status')){
                    if ( strtolower($data[0]->status) == "ok" ){
                        $message[] = "Notificación PUSH enviada (ID: ".$data[0]->id.") al dispositivo con token ".$deviceToken;
                    } else {
                        $message[] = "ERROR al enviar notificación PUSH al dispositivo con token " . $deviceToken . " (status is not ok)";
                    }
                } else {
                    $message[] = "ERROR al enviar notificación PUSH al dispositivo con token " . $deviceToken . " (campo status no existe)";
                }
            } else {
                $message[] = "ERROR al enviar notificación PUSH al dispositivo con token " . $deviceToken . " (campo data no existe)";
            }
        } else {
            $message[] = "ERROR al enviar notificación PUSH al dispositivo con token ".$deviceToken;
        }
        
        /**
         * FIN
         */
        $this->httpStatusCode = 201;
        $this->responseFormat['developerMessage'] = implode(" ~___~ ", $message);
        $this->responseFormat['userMessage'] = $this->responseFormat['developerMessage'];
        return null;
    }


    public function resetSimulation(){
        
        if ( !$this->request->query('userId') ){
            $this->httpStatusCode = 400;
            $this->responseFormat['developerMessage'] = "El parámetro userId es obligatorio";
            $this->responseFormat['userMessage'] = $this->responseFormat['developerMessage'];
            return null;
        }

        if ( !$this->request->query('routeId') ){
            $this->httpStatusCode = 400;
            $this->responseFormat['developerMessage'] = "El parámetro routeId es obligatorio";
            $this->responseFormat['userMessage'] = $this->responseFormat['developerMessage'];
            return null;
        }
        

        // ydaBJRdezbMXPMxSunDUcKzZTRH2
        $userId = $this->request->query('userId');
        
        // Trabajo
        $routeId = $this->request->query('routeId');
        
        $routeEfficiencyPercent = "100%";
        
        $routeStatus = "OPERANDO CON NORMALIDAD";
        
        // DeT4yxCxIm8ZFATlIcF8CS
        $deviceToken = $this->request->query('deviceToken');

        $message = [];

        /**
         * ACTUALIZAMOS LA RUTA
         */
        $firestore = new FirestoreClient();
        $collectionReference = $firestore->collection('users');
        $documentReference = $collectionReference->document($userId . '/routes/' . $routeId);

        $documentReference->update([
            [
                'path' => 'status', 
                'value' => $routeStatus
            ],
            [
                'path' => 'efficiency', 
                'value' => $routeEfficiencyPercent
            ]
        ]);

        $message[] = "Ruta ".$routeId." actualizada con status: ".$routeStatus." y efficency: ". $routeEfficiencyPercent;

        /**
         * FIN
         */
        $this->httpStatusCode = 204;
        $this->responseFormat['developerMessage'] = implode(" ~___~ ", $message);
        $this->responseFormat['userMessage'] = $this->responseFormat['developerMessage'];
        return null;
    }

}
