<?php

namespace GeometryLibrary\Controller;

use GeometryLibrary\Controller\ApiController;
use Cake\Cache\Cache;

class PolyUtilsController extends ApiController {

    // protected $paginationLimit = 50;
    // protected $paginationOffset = 0;

    protected $cacheEnabled = true;


    public function initialize() {
        parent::initialize();
    }
   
    /**
     * @api {post} /geometry-library/api/v1.0/poly-utils/isLocationOnEdge isLocationOnEdge
     * @apiVersion 1.0.0
     * @apiName isLocationOnEdge
     * @apiGroup PolyUtils
     *  
     * @apiParam {Object} point           Punto              
     * @apiParam {Number} point.lat         Latitud
     * @apiParam {Number} point.lon         Longitud
     * @apiParam {Object[]} poly             Polilínea
     * @apiParam {Number} poly.lat          Latitud
     * @apiParam {Number} poly.lon          Longitud
     * @apiParam {Number} [tolerance=0.1]   Valor de tolerancia en metros
     * @apiParam {Boolean} [geodesic=true]  En geometría, la línea geodésica se define como la línea de mínima longitud que une dos puntos en una superficie dada, y está contenida en esta superficie. El plano osculador de la geodésica es perpendicular en cualquier punto al plano tangente a la superficie. Las geodésicas de una superficie son las líneas "más rectas" posibles (con menor curvatura) fijado un punto y una dirección dada sobre dicha superficie.
     *
     * @apiDescription Calcula si el punto dado se encuentra en o cerca del borde de un polígono, dentro de una tolerancia especificada en metros. El borde del polígono se compone de grandes segmentos circulares si la geodésica es verdadera, y de segmentos Rhumb de lo contrario. El borde del polígono está implícitamente cerrado. Se incluye el segmento de cierre entre el primer punto y el último punto.
     * 
     * @apiExample Ejemplo de uso:
     *   {
     *       "point": {
     *           "lat": "-34.606788635253906",
     *           "lon": "-58.39219665527344"
     *       },
     *       "poly": [
     *           {
     *               "lat": "-34.606788635253906",
     *               "lon": "-58.39211654663086"
     *           },
     *           {
     *               "lat": "-34.60663986206055",
     *               "lon": "-58.39212417602539"
     *           },
     *           {
     *               "lat": "-34.605648040771484",
     *               "lon": "-58.39219665527344"
     *           }
     *       ]
     *   }
     *
     * 
     * @apiSuccess {Object}   results             
     * @apiSuccess {Boolean}   results.isLocationOnEdge     
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK 
     *   {
     *       "results": {
     *           "isLocationOnEdge": false
     *       }
     *   }
     * 
     * @apiError UnprocessableEntity   Unprocessable Entity
     * 
     * @apiErrorExample Response (Unprocessable Entity):
     * HTTP/1.1 422 Unprocessable Entity
     *   {
     *       "status": 422,
     *       "developerMessage": "Unprocessable Entity",
     *       "userMessage": "Unprocessable Entity",
     *       "errorCode": 422,
     *       "moreInfo": ""
     *   }
     * 
     * @apiError MethodNotAllowed   Method Not Allowed
     * 
     * @apiErrorExample Response (Method Not Allowed):
     * HTTP/1.1 405 Unprocessable Entity
     *   {
     *       "status": 405,
     *       "developerMessage": "Method Not Allowed",
     *       "userMessage": "Method Not Allowed",
     *       "errorCode": 405,
     *       "moreInfo": ""
     *   }
     * 
     * 
     */
    public function isLocationOnEdge() {
        $this->directResponse = false;

        if ( !$this->request->is('POST') ){
            $this->httpStatusCode = 405; // Method Not Allowed
            $this->responseFormat['developerMessage'] = "Method Not Allowed";
            $this->responseFormat['userMessage'] = "Method Not Allowed";
            $this->responseFormat['errorCode'] = 405;
            $this->responseFormat['moreInfo'] = '';
            return null;
        }

        $jsonInput = json_decode($this->request->input(), true);
        
        if ( is_null($jsonInput) ){
            $this->httpStatusCode = 422;
            $this->responseFormat['developerMessage'] = "Unprocessable Entity";
            $this->responseFormat['userMessage'] = "Unprocessable Entity";
            $this->responseFormat['errorCode'] = 422;
            $this->responseFormat['moreInfo'] = '';
            return null;
        }

        if ( !isset($jsonInput['point']) || !isset($jsonInput['poly']) ){
            $this->httpStatusCode = 422;
            $this->responseFormat['developerMessage'] = "Unprocessable Entity";
            $this->responseFormat['userMessage'] = "Unprocessable Entity";
            $this->responseFormat['errorCode'] = 422;
            $this->responseFormat['moreInfo'] = '';
            return null;
        }

        $jsonInput = $this->processEntityPointPolyline($jsonInput);

        $tolerance = ( isset($jsonInput['tolerance']) && is_bool($jsonInput['tolerance']) ) ? $jsonInput['tolerance'] : \GeometryLibrary\PolyUtil::DEFAULT_TOLERANCE;
        $geodesic = ( isset($jsonInput['geodesic']) && is_bool($jsonInput['geodesic']) ) ? $jsonInput['geodesic'] : true;

        $result =  \GeometryLibrary\PolyUtil::isLocationOnEdge($jsonInput['point'], $jsonInput['poly'], $tolerance, $geodesic);

        $response = ['isLocationOnEdge' => $result];
        $this->apiResponse = $response;
        $this->httpStatusCode = 200;
    }

    /**
     * @api {post} /geometry-library/api/v1.0/poly-utils/isLocationOnPath isLocationOnPath
     * @apiVersion 1.0.0
     * @apiName isLocationOnPath
     * @apiGroup PolyUtils
     *  
     * @apiParam {Object} point           Punto              
     * @apiParam {Number} point.lat         Latitud
     * @apiParam {Number} point.lon         Longitud
     * @apiParam {Object[]} poly             Polilínea
     * @apiParam {Number} poly.lat          Latitud
     * @apiParam {Number} poly.lon          Longitud
     * @apiParam {Number} [tolerance=0.1]   Valor de tolerancia en metros
     * @apiParam {Boolean} [geodesic=true]  En geometría, la línea geodésica se define como la línea de mínima longitud que une dos puntos en una superficie dada, y está contenida en esta superficie. El plano osculador de la geodésica es perpendicular en cualquier punto al plano tangente a la superficie. Las geodésicas de una superficie son las líneas "más rectas" posibles (con menor curvatura) fijado un punto y una dirección dada sobre dicha superficie.
     *
     * @apiDescription Calcula si el punto dado se encuentra en o cerca de una polilínea, dentro de una tolerancia especificada en metros. La polilínea se compone de grandes segmentos circulares si la geodésica es verdadera, y de segmentos Rhumb de lo contrario. La polilínea no está cerrada. El segmento de cierre entre el primer punto y el último punto no está incluido.
     * 
     * @apiExample Ejemplo de uso:
     *   {
     *       "point": {
     *           "lat": "-34.606788635253906",
     *           "lon": "-58.39219665527344"
     *       },
     *       "poly": [
     *           {
     *               "lat": "-34.606788635253906",
     *               "lon": "-58.39211654663086"
     *           },
     *           {
     *               "lat": "-34.60663986206055",
     *               "lon": "-58.39212417602539"
     *           },
     *           {
     *               "lat": "-34.605648040771484",
     *               "lon": "-58.39219665527344"
     *           }
     *       ]
     *   }
     *
     * 
     * @apiSuccess {Object}   results             
     * @apiSuccess {Boolean}   results.isLocationOnPath     
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK 
     *   {
     *       "results": {
     *           "isLocationOnPath": false
     *       }
     *   }
     * 
     * @apiError UnprocessableEntity   Unprocessable Entity
     * 
     * @apiErrorExample Response (Unprocessable Entity):
     * HTTP/1.1 422 Unprocessable Entity
     *   {
     *       "status": 422,
     *       "developerMessage": "Unprocessable Entity",
     *       "userMessage": "Unprocessable Entity",
     *       "errorCode": 422,
     *       "moreInfo": ""
     *   }
     * 
     * @apiError MethodNotAllowed   Method Not Allowed
     * 
     * @apiErrorExample Response (Method Not Allowed):
     * HTTP/1.1 405 Unprocessable Entity
     *   {
     *       "status": 405,
     *       "developerMessage": "Method Not Allowed",
     *       "userMessage": "Method Not Allowed",
     *       "errorCode": 405,
     *       "moreInfo": ""
     *   }
     * 
     * 
     */

    public function isLocationOnPath() {
        $this->directResponse = false;

        if ( !$this->request->is('POST') ){
            $this->httpStatusCode = 405; // Method Not Allowed
            $this->responseFormat['developerMessage'] = "Method Not Allowed";
            $this->responseFormat['userMessage'] = "Method Not Allowed";
            $this->responseFormat['errorCode'] = 405;
            $this->responseFormat['moreInfo'] = '';
            return null;
        }

        $jsonInput = json_decode($this->request->input(), true);
        
        if ( is_null($jsonInput) ){
            $this->httpStatusCode = 422;
            $this->responseFormat['developerMessage'] = "Unprocessable Entity";
            $this->responseFormat['userMessage'] = "Unprocessable Entity";
            $this->responseFormat['errorCode'] = 422;
            $this->responseFormat['moreInfo'] = '';
            return null;
        }

        if ( !isset($jsonInput['point']) || !isset($jsonInput['poly']) ){
            $this->httpStatusCode = 422;
            $this->responseFormat['developerMessage'] = "Unprocessable Entity";
            $this->responseFormat['userMessage'] = "Unprocessable Entity";
            $this->responseFormat['errorCode'] = 422;
            $this->responseFormat['moreInfo'] = '';
            return null;
        }

        $jsonInput = $this->processEntityPointPolyline($jsonInput);

        $tolerance = ( isset($jsonInput['tolerance']) && is_bool($jsonInput['tolerance']) ) ? $jsonInput['tolerance'] : \GeometryLibrary\PolyUtil::DEFAULT_TOLERANCE;
        $geodesic = ( isset($jsonInput['geodesic']) && is_bool($jsonInput['geodesic']) ) ? $jsonInput['geodesic'] : true;

        $result =  \GeometryLibrary\PolyUtil::isLocationOnPath($jsonInput['point'], $jsonInput['poly'], $tolerance, $geodesic);

        $response = ['isLocationOnPath' => $result];
        $this->apiResponse = $response;
        $this->httpStatusCode = 200;
    }

    /**
     * @api {post} /geometry-library/api/v1.0/poly-utils/containsLocation containsLocation
     * @apiVersion 1.0.0
     * @apiName containsLocation
     * @apiGroup PolyUtils
     *  
     * @apiParam {Object} point           Punto              
     * @apiParam {Number} point.lat         Latitud
     * @apiParam {Number} point.lon         Longitud
     * @apiParam {Object[]} poly             Polilínea
     * @apiParam {Number} poly.lat          Latitud
     * @apiParam {Number} poly.lon          Longitud
     * @apiParam {Boolean} [geodesic=false]  En geometría, la línea geodésica se define como la línea de mínima longitud que une dos puntos en una superficie dada, y está contenida en esta superficie. El plano osculador de la geodésica es perpendicular en cualquier punto al plano tangente a la superficie. Las geodésicas de una superficie son las líneas "más rectas" posibles (con menor curvatura) fijado un punto y una dirección dada sobre dicha superficie.
     *
     * @apiDescription Calcula si el punto dado se encuentra dentro del polígono especificado. El polígono siempre se considera cerrado, independientemente de si el último punto es igual al primero o no. El interior se define como que no contiene el Polo Sur. El Polo Sur siempre está afuera. El polígono está formado por segmentos de gran círculo si la geodésica es verdadera, y de segmentos de rumbo (loxodrómico) de lo contrario.
     * 
     * @apiExample Ejemplo de uso:
     *   {
     *       "point": {
     *           "lat": "-34.606788635253906",
     *           "lon": "-58.39219665527344"
     *       },
     *       "poly": [
     *           {
     *               "lat": "-34.606788635253906",
     *               "lon": "-58.39211654663086"
     *           },
     *           {
     *               "lat": "-34.60663986206055",
     *               "lon": "-58.39212417602539"
     *           },
     *           {
     *               "lat": "-34.605648040771484",
     *               "lon": "-58.39219665527344"
     *           }
     *       ]
     *   }
     *
     * 
     * @apiSuccess {Object}   results             
     * @apiSuccess {Boolean}   results.containsLocation     
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK 
     *   {
     *       "results": {
     *           "containsLocation": false
     *       }
     *   }
     * 
     * @apiError UnprocessableEntity   Unprocessable Entity
     * 
     * @apiErrorExample Response (Unprocessable Entity):
     * HTTP/1.1 422 Unprocessable Entity
     *   {
     *       "status": 422,
     *       "developerMessage": "Unprocessable Entity",
     *       "userMessage": "Unprocessable Entity",
     *       "errorCode": 422,
     *       "moreInfo": ""
     *   }
     * 
     * @apiError MethodNotAllowed   Method Not Allowed
     * 
     * @apiErrorExample Response (Method Not Allowed):
     * HTTP/1.1 405 Unprocessable Entity
     *   {
     *       "status": 405,
     *       "developerMessage": "Method Not Allowed",
     *       "userMessage": "Method Not Allowed",
     *       "errorCode": 405,
     *       "moreInfo": ""
     *   }
     * 
     * 
     */
    public function containsLocation() {
        $this->directResponse = false;

        if ( !$this->request->is('POST') ){
            $this->httpStatusCode = 405; // Method Not Allowed
            $this->responseFormat['developerMessage'] = "Method Not Allowed";
            $this->responseFormat['userMessage'] = "Method Not Allowed";
            $this->responseFormat['errorCode'] = 405;
            $this->responseFormat['moreInfo'] = '';
            return null;
        }

        $jsonInput = json_decode($this->request->input(), true);
        
        if ( is_null($jsonInput) ){
                $this->httpStatusCode = 422;
                $this->responseFormat['developerMessage'] = "Unprocessable Entity";
                $this->responseFormat['userMessage'] = "Unprocessable Entity";
                $this->responseFormat['errorCode'] = 422;
                $this->responseFormat['moreInfo'] = '';
                return null;
        }

        if ( !isset($jsonInput['point']) || !isset($jsonInput['poly']) ){
            $this->httpStatusCode = 422;
            $this->responseFormat['developerMessage'] = "Unprocessable Entity";
            $this->responseFormat['userMessage'] = "Unprocessable Entity";
            $this->responseFormat['errorCode'] = 422;
            $this->responseFormat['moreInfo'] = '';
            return null;
        }

        $geodesic = ( isset($jsonInput['geodesic']) && is_bool($jsonInput['geodesic']) ) ? $jsonInput['geodesic'] : false;

        $jsonInput = $this->processEntityPointPolyline($jsonInput);

        $result =  \GeometryLibrary\PolyUtil::isLocationOnPath($jsonInput['point'], $jsonInput['poly'], $geodesic);

        $response = ['containsLocation' => $result];
        $this->apiResponse = $response;
        $this->httpStatusCode = 200;
    }    

    /**
     * @api {post} /geometry-library/api/v1.0/poly-utils/distanceToLine distanceToLine
     * @apiVersion 1.0.0
     * @apiName distanceToLine
     * @apiGroup PolyUtils
     *  
     * @apiParam {Object} point           Punto              
     * @apiParam {Number} point.lat         Latitud
     * @apiParam {Number} point.lon         Longitud
     * @apiParam {Object} from           Desde              
     * @apiParam {Number} from.lat         Latitud
     * @apiParam {Number} from.lon         Longitud
     * @apiParam {Object} to           Hasta              
     * @apiParam {Number} to.lat         Latitud
     * @apiParam {Number} to.lon         Longitud
     *
     * @apiDescription Calcula la distancia en la esfera entre el punto point y el segmento de línea de from a to.
     * 
     * @apiExample Ejemplo de uso:
     *   {
     *       "point":{
     *           "lat":"-34.605499",
     *           "lon":"-58.390765"
     *       },
     *       "from":{
     *           "lat":"-34.605738",
     *           "lon":"-58.393769"
     *       },
     *       "to":{
     *           "lat":"-34.605738",
     *           "lon":"-58.393769"
     *       }
     *   }
     *
     * 
     * @apiSuccess {Object}     results             
     * @apiSuccess {Object}     results.distanceToLine     
     * @apiSuccess {Number}     results.distanceToLine.distance Distancia     
     * @apiSuccess {String="m"|"km"} results.distanceToLine.unit Unidad de medida. Puede ser "m" para metros y "km" para kilómetros     
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK 
     *   {
     *       "results": {
     *           "distanceToLine": {
     *               "distance": 276.2151053896317,
     *               "unit": "m"
     *           }
     *       }
     *   }
     * 
     * @apiError UnprocessableEntity   Unprocessable Entity
     * 
     * @apiErrorExample Response (Unprocessable Entity):
     * HTTP/1.1 422 Unprocessable Entity
     *   {
     *       "status": 422,
     *       "developerMessage": "Unprocessable Entity",
     *       "userMessage": "Unprocessable Entity",
     *       "errorCode": 422,
     *       "moreInfo": ""
     *   }
     * 
     * @apiError MethodNotAllowed   Method Not Allowed
     * 
     * @apiErrorExample Response (Method Not Allowed):
     * HTTP/1.1 405 Unprocessable Entity
     *   {
     *       "status": 405,
     *       "developerMessage": "Method Not Allowed",
     *       "userMessage": "Method Not Allowed",
     *       "errorCode": 405,
     *       "moreInfo": ""
     *   }
     * 
     * 
     */

    public function distanceToLine() {
        $this->directResponse = false;

        if ( !$this->request->is('POST') ){
            $this->httpStatusCode = 405; // Method Not Allowed
            $this->responseFormat['developerMessage'] = "Method Not Allowed";
            $this->responseFormat['userMessage'] = "Method Not Allowed";
            $this->responseFormat['errorCode'] = 405;
            $this->responseFormat['moreInfo'] = '';
            return null;
        }

        $jsonInput = json_decode($this->request->input(), true);
        
        if ( is_null($jsonInput) ){
            $this->httpStatusCode = 422;
            $this->responseFormat['developerMessage'] = "Unprocessable Entity";
            $this->responseFormat['userMessage'] = "Unprocessable Entity";
            $this->responseFormat['errorCode'] = 422;
            $this->responseFormat['moreInfo'] = '';
            return null;
        }

        if ( !isset($jsonInput['point']) || !isset($jsonInput['from']) || !isset($jsonInput['to']) ){
            $this->httpStatusCode = 422;
            $this->responseFormat['developerMessage'] = "Unprocessable Entity";
            $this->responseFormat['userMessage'] = "Unprocessable Entity";
            $this->responseFormat['errorCode'] = 422;
            $this->responseFormat['moreInfo'] = '';
            return null;
        }

        $jsonInput = $this->processEntityPointLine($jsonInput);

        $result =  \GeometryLibrary\PolyUtil::distanceToLine($jsonInput['point'], $jsonInput['from'], $jsonInput['to']);

        $unit = "m";

        if ( $result > 1000 ){
            $unit = "km";
            $result = $result / 1000;
        }

        $response = ['distanceToLine' => 
            [
                "distance" => $result,
                "unit" => $unit
            ]
        ];
        $this->apiResponse = $response;
        $this->httpStatusCode = 200;
    }    

    /**
     * @api {post} /geometry-library/api/v1.0/poly-utils/encode encode
     * @apiVersion 1.0.0
     * @apiName encode
     * @apiGroup PolyUtils
     *  
     * @apiParam {Object[]} poly             Polilínea
     * @apiParam {Number} poly.lat          Latitud
     * @apiParam {Number} poly.lon          Longitud
     *
     * @apiDescription Codifica una secuencia de puntos (latitudes y longitudes) en una cadena de ruta codificada.
     * 
     * @apiExample Ejemplo de uso:
     *   {
     *       "poly": [
     *           {
     *               "lat": "-34.606788635253906",
     *               "lon": "-58.39211654663086"
     *           },
     *           {
     *               "lat": "-34.60663986206055",
     *               "lon": "-58.39212417602539"
     *           },
     *           {
     *               "lat": "-34.605648040771484",
     *               "lon": "-58.39219665527344"
     *           }
     *       ]
     *   }
     *
     * 
     * @apiSuccess {Object}   results             
     * @apiSuccess {Number}   results.encode     
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK 
     *   {
     *       "results": {
     *           "endode": "lcfrEvukcJ]?eEN"
     *       }
     *   }
     * 
     * @apiError UnprocessableEntity   Unprocessable Entity
     * 
     * @apiErrorExample Response (Unprocessable Entity):
     * HTTP/1.1 422 Unprocessable Entity
     *   {
     *       "status": 422,
     *       "developerMessage": "Unprocessable Entity",
     *       "userMessage": "Unprocessable Entity",
     *       "errorCode": 422,
     *       "moreInfo": ""
     *   }
     * 
     * @apiError MethodNotAllowed   Method Not Allowed
     * 
     * @apiErrorExample Response (Method Not Allowed):
     * HTTP/1.1 405 Unprocessable Entity
     *   {
     *       "status": 405,
     *       "developerMessage": "Method Not Allowed",
     *       "userMessage": "Method Not Allowed",
     *       "errorCode": 405,
     *       "moreInfo": ""
     *   }
     * 
     * 
     */
    public function encode() {
        $this->directResponse = false;

        if ( !$this->request->is('POST') ){
            $this->httpStatusCode = 405; // Method Not Allowed
            $this->responseFormat['developerMessage'] = "Method Not Allowed";
            $this->responseFormat['userMessage'] = "Method Not Allowed";
            $this->responseFormat['errorCode'] = 405;
            $this->responseFormat['moreInfo'] = '';
            return null;
        }

        $jsonInput = json_decode($this->request->input(), true);
        
        if ( is_null($jsonInput) ){
            $this->httpStatusCode = 422;
            $this->responseFormat['developerMessage'] = "Unprocessable Entity";
            $this->responseFormat['userMessage'] = "Unprocessable Entity";
            $this->responseFormat['errorCode'] = 422;
            $this->responseFormat['moreInfo'] = '';
            return null;
        }

        if ( !isset($jsonInput['poly']) ){
            $this->httpStatusCode = 422;
            $this->responseFormat['developerMessage'] = "Unprocessable Entity";
            $this->responseFormat['userMessage'] = "Unprocessable Entity";
            $this->responseFormat['errorCode'] = 422;
            $this->responseFormat['moreInfo'] = '';
            return null;
        }

        $jsonInput = $this->processEntityPointPolyline($jsonInput);

        $result =  \GeometryLibrary\PolyUtil::encode($jsonInput['poly']);

        $response = ['encode' => $result];
        $this->apiResponse = $response;
        $this->httpStatusCode = 200;
    }

    /**
     * @api {post} /geometry-library/api/v1.0/poly-utils/decode decode
     * @apiVersion 1.0.0
     * @apiName decode
     * @apiGroup PolyUtils
     *  
     * @apiParam {Object} encode            Cadena de ruta codificada
     *
     * @apiDescription Decodifica una cadena de ruta codificada en una secuencia de puntos (latitudes y longitudes).
     * 
     * @apiExample Ejemplo de uso:
     *   {
     *       "encode": "lcfrEvukcJ]?eobEN~|hQ?_seK?_glW?"
     *   }
     *
     * 
     * @apiSuccess {Object}     results             
     * @apiSuccess {Object[]}   results.decode
     * @apiSuccess {Number} results.decode.lat          Latitud
     * @apiSuccess {Number} results.decode.lon          Longitud
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK 
     *   {
     *       "results": {
     *           "decode": [
     *             {
     *                 "lat": "-34.606788635253906",
     *                 "lon": "-58.39211654663086"
     *             },
     *             {
     *                 "lat": "-34.60663986206055",
     *                 "lon": "-58.39212417602539"
     *             },
     *             {
     *                 "lat": "-34.605648040771484",
     *                 "lon": "-58.39219665527344"
     *             }
     *           ]
     *       }
     *   }
     * 
     * @apiError UnprocessableEntity   Unprocessable Entity
     * 
     * @apiErrorExample Response (Unprocessable Entity):
     * HTTP/1.1 422 Unprocessable Entity
     *   {
     *       "status": 422,
     *       "developerMessage": "Unprocessable Entity",
     *       "userMessage": "Unprocessable Entity",
     *       "errorCode": 422,
     *       "moreInfo": ""
     *   }
     * 
     * @apiError MethodNotAllowed   Method Not Allowed
     * 
     * @apiErrorExample Response (Method Not Allowed):
     * HTTP/1.1 405 Unprocessable Entity
     *   {
     *       "status": 405,
     *       "developerMessage": "Method Not Allowed",
     *       "userMessage": "Method Not Allowed",
     *       "errorCode": 405,
     *       "moreInfo": ""
     *   }
     * 
     * 
     */
    public function decode() {
        $this->directResponse = false;

        if ( !$this->request->is('POST') ){
            $this->httpStatusCode = 405; // Method Not Allowed
            $this->responseFormat['developerMessage'] = "Method Not Allowed";
            $this->responseFormat['userMessage'] = "Method Not Allowed";
            $this->responseFormat['errorCode'] = 405;
            $this->responseFormat['moreInfo'] = '';
            return null;
        }

        $jsonInput = json_decode($this->request->input(), true);
        
        if ( is_null($jsonInput) ){
            $this->httpStatusCode = 422;
            $this->responseFormat['developerMessage'] = "Unprocessable Entity";
            $this->responseFormat['userMessage'] = "Unprocessable Entity";
            $this->responseFormat['errorCode'] = 422;
            $this->responseFormat['moreInfo'] = '';
            return null;
        }

        if ( !isset($jsonInput['encode']) ){
            $this->httpStatusCode = 422;
            $this->responseFormat['developerMessage'] = "Unprocessable Entity";
            $this->responseFormat['userMessage'] = "Unprocessable Entity";
            $this->responseFormat['errorCode'] = 422;
            $this->responseFormat['moreInfo'] = '';
            return null;
        }

        $result =  \GeometryLibrary\PolyUtil::decode($jsonInput['encode']);

        $response = ['decode' => $result];
        $this->apiResponse = $response;
        $this->httpStatusCode = 200;
    }

    protected function processEntityPointPolyline($json){
        $response = $json;

        if ( isset($response['poly']) ){
            $responseCount = count($response['poly']);
            for ($i=0; $i<$responseCount; $i++ ){
                if (isset( $response['poly'][$i]['lon'])){
                    $response['poly'][$i]['lng'] = $response['poly'][$i]['lon'];
                    unset($response['poly'][$i]['lon']);
                }
            }
        }

        if ( isset($response['point']) ){
            if (isset($response['point']['lon'])){
                $response['point']['lng'] = $response['point']['lon'];
                unset($response['point']['lon']);
            }
        }

        return $response;
    }

    protected function processEntityPointLine($json){
        $response = $json;

        if ( isset($response['point']) ){
            if (isset($response['point']['lon'])){
                $response['point']['lng'] = $response['point']['lon'];
                unset($response['point']['lon']);
            }
        }

        if ( isset($response['from']) ){
            if (isset($response['from']['lon'])){
                $response['from']['lng'] = $response['from']['lon'];
                unset($response['from']['lon']);
            }
        }

        if ( isset($response['to']) ){
            if (isset($response['to']['lon'])){
                $response['to']['lng'] = $response['to']['lon'];
                unset($response['to']['lon']);
            }
        }

        return $response;
    }

}
