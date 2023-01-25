<?php

namespace GeometryLibrary\Controller;

use GeometryLibrary\Controller\ApiController;
use Cake\Cache\Cache;

class SphericalUtilsController extends ApiController {

    // protected $paginationLimit = 50;
    // protected $paginationOffset = 0;

    protected $cacheEnabled = true;


    public function initialize() {
        parent::initialize();
    }

    /**
     * @api {post} /geometry-library/api/v1.0/spherical-utils/computeHeading computeHeading
     * @apiVersion 1.0.0
     * @apiName computeHeading
     * @apiGroup SphericalUtils
     *  
     * @apiParam {Object} from           El punto Origen              
     * @apiParam {Number} from.lat         Latitud
     * @apiParam {Number} from.lon         Longitud
     * @apiParam {Object} to           El punto Destino              
     * @apiParam {Number} to.lat         Latitud
     * @apiParam {Number} to.lon         Longitud
     *
     * @apiDescription Devuelve el encabezado de un Punto a otro Punto. Los encabezados se expresan en grados en sentido horario desde el norte dentro del rango [-180,180).
     * 
     * @apiExample Ejemplo de uso:
     *   {
     *       "from":{
     *           "lat":"-34.000000",
     *           "lon":"-59.000000"
     *       },
     *       "to":{
     *           "lat":"-30.000000",
     *           "lon":"-58.000000"
     *       }
     *   }
     *
     * 
     * @apiSuccess {Object}   results             
     * @apiSuccess {Boolean}   results.computeHeading     
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK 
     *   {
     *       "results": {
     *           "computeHeading": 12.2379278726376
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
    public function computeHeading() {
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

        if ( !isset($jsonInput['from']) || !isset($jsonInput['to']) ){
            $this->httpStatusCode = 422;
            $this->responseFormat['developerMessage'] = "Unprocessable Entity";
            $this->responseFormat['userMessage'] = "Unprocessable Entity";
            $this->responseFormat['errorCode'] = 422;
            $this->responseFormat['moreInfo'] = '';
            return null;
        }

        $jsonInput = $this->processEntityComputeHeading($jsonInput);

        $result =  \GeometryLibrary\SphericalUtil::computeHeading($jsonInput['from'], $jsonInput['to']);

        $response = ['computeHeading' => $result];
        $this->apiResponse = $response;
        $this->httpStatusCode = 200;
    }
   
    /**
     * @api {post} /geometry-library/api/v1.0/spherical-utils/computeOffset computeOffset
     * @apiVersion 1.0.0
     * @apiName computeOffset
     * @apiGroup SphericalUtils
     *  
     * @apiParam {Object} from           El punto Origen              
     * @apiParam {Number} from.lat         Latitud
     * @apiParam {Number} from.lon         Longitud
     * @apiParam {Number} distance       La distancia a recorrer, en metros
     * @apiParam {Number} heading        El rumbo en grados en sentido horario desde el norte
     *
     * @apiDescription Devuelve el Punto resultante de mover una distancia desde un origen en el rumbo especificado (expresado en grados en sentido horario desde el norte).
     * 
     * @apiExample Ejemplo de uso:
     *   {
     *       "from":{
     *           "lat":"-34.000000",
     *           "lon":"-59.000000"
     *       },
     *       "distance": 150,
     *       "heading": 0
     *   }
     *
     * 
     * @apiSuccess {Object}   results             
     * @apiSuccess {Object}   results.computeOffset
     * @apiSuccess {Number} results.computeOffset.lat         Latitud
     * @apiSuccess {Number} results.computeOffset.lon         Longitud     
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK 
     *   {
     *       "results": {
     *           "computeOffset": {
     *               "lat": -33.998651019496755,
     *               "lng": -58.99999999999999
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
    public function computeOffset() {
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

        if ( !isset($jsonInput['from']) || !isset($jsonInput['distance']) || !isset($jsonInput['heading']) ){
            $this->httpStatusCode = 422;
            $this->responseFormat['developerMessage'] = "Unprocessable Entity";
            $this->responseFormat['userMessage'] = "Unprocessable Entity";
            $this->responseFormat['errorCode'] = 422;
            $this->responseFormat['moreInfo'] = '';
            return null;
        }

        $jsonInput = $this->processEntityComputeHeading($jsonInput);

        $result =  \GeometryLibrary\SphericalUtil::computeOffset($jsonInput['from'], $jsonInput['distance'], $jsonInput['heading']);

        $response = ['computeOffset' => $result];
        $this->apiResponse = $response;
        $this->httpStatusCode = 200;
    }   

    /**
     * @api {post} /geometry-library/api/v1.0/spherical-utils/computeOffsetOrigin computeOffsetOrigin
     * @apiVersion 1.0.0
     * @apiName computeOffsetOrigin
     * @apiGroup SphericalUtils
     *  
     * @apiParam {Object} to           El punto Destino              
     * @apiParam {Number} to.lat         Latitud
     * @apiParam {Number} to.lon         Longitud
     * @apiParam {Number} distance       La distancia a recorrer, en metros
     * @apiParam {Number} heading        El rumbo en grados en sentido horario desde el norte
     *
     * @apiDescription Devuelve la ubicación de origen cuando se le proporciona un punto destino, metros recorridos y rumbo original. El campo heading se expresa en grados en sentido horario desde el norte. Esta función devuelve nulo cuando no hay una solución disponible.
     * 
     * @apiExample Ejemplo de uso:
     *   {
     *       "to":{
     *           "lat":"-33.998651019496755",
     *           "lon":"-58.99999999999999"
     *       },
     *       "distance": 150,
     *       "heading": 0
     *   }
     *
     * 
     * @apiSuccess {Object}     results             
     * @apiSuccess {Object}     results.computeOffsetOrigin
     * @apiSuccess {Number}     results.computeOffset.lat         Latitud
     * @apiSuccess {Number}     results.computeOffset.lon         Longitud     
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK 
     *   {
     *       "results": {
     *           "computeOffset": {
     *               "lat": -10.987548569233995,
     *               "lng": -193685.57465069287
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

    public function computeOffsetOrigin() {
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

        if ( !isset($jsonInput['to']) || !isset($jsonInput['distance']) || !isset($jsonInput['heading']) ){
            $this->httpStatusCode = 422;
            $this->responseFormat['developerMessage'] = "Unprocessable Entity";
            $this->responseFormat['userMessage'] = "Unprocessable Entity";
            $this->responseFormat['errorCode'] = 422;
            $this->responseFormat['moreInfo'] = '';
            return null;
        }

        $jsonInput = $this->processEntityComputeHeading($jsonInput);

        $result =  \GeometryLibrary\SphericalUtil::computeOffsetOrigin($jsonInput['to'], $jsonInput['distance'], $jsonInput['heading']);

        $response = ['computeOffsetOrigin' => $result];
        $this->apiResponse = $response;
        $this->httpStatusCode = 200;
    }


    /**
     * @api {post} /geometry-library/api/v1.0/spherical-utils/interpolate interpolate
     * @apiVersion 1.0.0
     * @apiName interpolate
     * @apiGroup SphericalUtils
     *  
     * @apiParam {Object} from           El punto Origen              
     * @apiParam {Number} from.lat         Latitud
     * @apiParam {Number} from.lon         Longitud
     * @apiParam {Object} to           El punto Destino              
     * @apiParam {Number} to.lat         Latitud
     * @apiParam {Number} to.lon         Longitud
     * @apiParam {Object} fraction       Una fracción de la distancia a recorrer              
     * 
     * @apiDescription  Devuelve el Punto que se encuentra la fracción dada del camino entre el Punto de origen y el Punto de destino.
     * 
     * @apiExample Ejemplo de uso:
     *   {
     *       "from":{
     *           "lat":"-34.606788635253906",
     *           "lon":"-58.39211654663086"
     *       },
     *       "to":{
     *           "lat":"-33.606788635253906",
     *           "lon":"-58.39212417602539"
     *       },
     *       "fraction": 5
     *   }
     *
     * 
     * @apiSuccess {Object}    results             
     * @apiSuccess {Object}   results.interpolate
     * @apiSuccess {Number}   results.interpolate.lat
     * @apiSuccess {Number}   results.interpolate.lon
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK 
     *   {
     *       "results": {
     *           "interpolate": {
     *               "lat": -29.6067886352496,
     *               "lon": -58.39215304409501
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
    public function interpolate() {
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

        if ( !isset($jsonInput['from']) || !isset($jsonInput['to']) || !isset($jsonInput['fraction']) ){
            $this->httpStatusCode = 422;
            $this->responseFormat['developerMessage'] = "Unprocessable Entity";
            $this->responseFormat['userMessage'] = "Unprocessable Entity";
            $this->responseFormat['errorCode'] = 422;
            $this->responseFormat['moreInfo'] = '';
            return null;
        }

        $jsonInput = $this->processEntityComputeHeading($jsonInput);

        $result =  \GeometryLibrary\SphericalUtil::interpolate($jsonInput['from'], $jsonInput['to'], $jsonInput['fraction']);

        $response = ['interpolate' => $result];
        $this->apiResponse = $response;
        $this->httpStatusCode = 200;
    }


    /**
     * @api {post} /geometry-library/api/v1.0/spherical-utils/computeDistanceBetween computeDistanceBetween
     * @apiVersion 1.0.0
     * @apiName computeDistanceBetween
     * @apiGroup SphericalUtils
     *  
     * @apiParam {Object} from         El punto Origen              
     * @apiParam {Number} from.lat         Latitud
     * @apiParam {Number} from.lon         Longitud
     * @apiParam {Object} to           El punto Destino              
     * @apiParam {Number} to.lat         Latitud
     * @apiParam {Number} to.lon         Longitud
     * 
     * @apiDescription  Devuelve la distancia entre dos puntos, en metros.
     * 
     * @apiExample Ejemplo de uso:
     *   {
     *       "from":{
     *           "lat":"-34.606788635253906",
     *           "lon":"-58.39211654663086"
     *       },
     *       "to":{
     *           "lat":"-33.606788635253906",
     *           "lon":"-58.39212417602539"
     *       }
     *   }
     *
     * 
     * @apiSuccess {Object}    results             
     * @apiSuccess {Number}    results.computeDistanceBetween Distancia entre los dos puntos expresada en metros
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK 
     *   {
     *       "results": {
     *           "computeDistanceBetween": 111195.08372641008
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
    public function computeDistanceBetween() {
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

        if ( !isset($jsonInput['from']) || !isset($jsonInput['to']) ){
            $this->httpStatusCode = 422;
            $this->responseFormat['developerMessage'] = "Unprocessable Entity";
            $this->responseFormat['userMessage'] = "Unprocessable Entity";
            $this->responseFormat['errorCode'] = 422;
            $this->responseFormat['moreInfo'] = '';
            return null;
        }

        $jsonInput = $this->processEntityComputeHeading($jsonInput);

        $result =  \GeometryLibrary\SphericalUtil::computeDistanceBetween($jsonInput['from'], $jsonInput['to']);

        $response = ['computeDistanceBetween' => $result];
        $this->apiResponse = $response;
        $this->httpStatusCode = 200;
    }
   
    /**
     * @api {post} /geometry-library/api/v1.0/spherical-utils/computeLength computeLength
     * @apiVersion 1.0.0
     * @apiName computeLength
     * @apiGroup SphericalUtils
     *  
     * @apiParam {Object[]} poly         Polilínea
     * @apiParam {Number} poly.lat         Latitud
     * @apiParam {Number} poly.lon         Longitud
     * 
     * @apiDescription  Devuelve la longitud de la ruta dada, en metros, en la Tierra.
     * 
     * @apiExample Ejemplo de uso:
     *   {
     *     "poly": [
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
     * @apiSuccess {Object}    results             
     * @apiSuccess {Number}    results.computeLength Longitud de la ruta dada, en metros, en la Tierra
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK 
     *   {
     *       "results": {
     *           "computeLength": 127.04254201169243
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
    public function computeLength() {
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

        $jsonInput = $this->processEntityPolyline($jsonInput);

        $result =  \GeometryLibrary\SphericalUtil::computeLength($jsonInput['poly']);

        $response = ['computeLength' => $result];
        $this->apiResponse = $response;
        $this->httpStatusCode = 200;
    }


    /**
     * @api {post} /geometry-library/api/v1.0/spherical-utils/computeArea computeArea
     * @apiVersion 1.0.0
     * @apiName computeArea
     * @apiGroup SphericalUtils
     *  
     * @apiParam {Object[]} poly         Polilínea (Un camino cerrado)
     * @apiParam {Number} poly.lat         Latitud
     * @apiParam {Number} poly.lon         Longitud
     * 
     * @apiDescription  Devuelve el área de un camino cerrado en la Tierra, en metros cuadrados.
     * 
     * @apiExample Ejemplo de uso:
     *   {
     *     "poly": [
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
     * @apiSuccess {Object}    results             
     * @apiSuccess {Number}    results.computeArea Área de un camino cerrado en la Tierra expresada en metros cuadrados
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK 
     *   {
     *       "results": {
     *           "computeArea": 16.364770561952934
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
    public function computeArea() {
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

        $jsonInput = $this->processEntityPolyline($jsonInput);

        $result =  \GeometryLibrary\SphericalUtil::computeArea($jsonInput['poly']);

        $response = ['computeArea' => $result];
        $this->apiResponse = $response;
        $this->httpStatusCode = 200;
    }

    /**
     * @api {post} /geometry-library/api/v1.0/spherical-utils/computeSignedArea computeSignedArea
     * @apiVersion 1.0.0
     * @apiName computeSignedArea
     * @apiGroup SphericalUtils
     *  
     * @apiParam {Object[]} poly         Polilínea (Un camino cerrado)
     * @apiParam {Number} poly.lat         Latitud
     * @apiParam {Number} poly.lon         Longitud
     * 
     * @apiDescription  Devuelve el área firmada de un camino cerrado en la Tierra. El signo del área puede usarse para determinar la orientación del camino. "adentro" es la superficie que no contiene el Polo Sur.
     * 
     * @apiExample Ejemplo de uso:
     *   {
     *     "poly": [
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
     * @apiSuccess {Object}    results             
     * @apiSuccess {Number}    results.computeSignedArea El área del bucle en metros cuadrados
     * 
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK 
     *   {
     *       "results": {
     *           "computeSignedArea": 16.364770561952934
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
    public function computeSignedArea() {
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

        $jsonInput = $this->processEntityPolyline($jsonInput);

        $result =  \GeometryLibrary\SphericalUtil::computeSignedArea($jsonInput['poly']);

        $response = ['computeSignedArea' => $result];
        $this->apiResponse = $response;
        $this->httpStatusCode = 200;
    }

    protected function processEntityComputeHeading($json){
        $response = $json;

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

    protected function processEntityPolyline($json){
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

        return $response;
    }

}
