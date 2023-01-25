define({ "api": [
  {
    "type": "get",
    "url": "/transito/api/v1.0/cortes",
    "title": "Cortes",
    "version": "1.0.0",
    "name": "IndexCortes",
    "group": "Transito",
    "description": "<p>Retorna los cortes de tránsito.<br/></p>",
    "parameter": {
      "fields": {
        "Query string": [
          {
            "group": "Query string",
            "type": "String",
            "optional": true,
            "field": "sort",
            "description": "<p>Permite ordenar por un campo (del primer nivel) de forma ascendente o descendente. Para ordenar de forma descendente se debe poner como prefijo del campo un -</p> <pre class=\"prettyprint\">?sort=id (orden ascendente por campo id) </code></pre> <pre class=\"prettyprint\">?sort=-id (orden descendente por campo id) </code></pre>"
          },
          {
            "group": "Query string",
            "type": "String",
            "optional": true,
            "field": "limit",
            "description": "<p>Indica la cantidad máxima de elementos a retornar.</p> <pre class=\"prettyprint\">?limit=5 </code></pre>"
          },
          {
            "group": "Query string",
            "type": "String",
            "optional": true,
            "field": "offset",
            "description": "<p>Indica desde que posición se entregarán los elementos.</p> <pre class=\"prettyprint\">?offset=10 </code></pre>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Ejemplo de uso:",
        "content": "GET /transito/api/v1.0/cortes HTTP/1.1\nHost: sip1.verzi.com.ar\nCache-Control: no-cache",
        "type": "json"
      }
    ],
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "GET 'http://sip1.verzi.com.ar/transito/api/v1.0/cortes?offset=0&limit=1'\nHTTP/1.1 200 Ok\n\n  {\n      \"metadata\":{\n          \"resultset\":{\n              \"count\":1,\n              \"offset\":0,\n              \"limit\":1\n          }\n      },\n      \"results\":[\n          {\n              \"id\":\"batransito-2197397-Closure-522\",\n              \"parent_event\":\"batransito-2197397\",\n              \"type\":\"ROAD_CLOSED\",\n              \"description\":\"Buenos Aires: Debido a Otros en Area 1 en TTE.GENERAL JUAN DOMINGO PERON (E) en AV. CALLAO (batransito)\",\n              \"location\":{\n                  \"street\":\"Av. Callao\",\n                  \"polyline\":\"-34.606788635253906 -58.39211654663086 -34.60663986206055 -58.39212417602539 -34.605648040771484 -58.39219665527344 \",\n                  \"direction\":\"ONE_DIRECTION\",\n                  \"polyline_coordinates\":[\n                  {\n                      \"lat\":\"-34.606788635253906\",\n                      \"lon\":\"-58.39211654663086\",\n                      \"address\":\"Av. Callao 186, C1022AAO CABA, Argentina\"\n                  },\n                  {\n                      \"lat\":\"-34.60663986206055\",\n                      \"lon\":\"-58.39212417602539\",\n                      \"address\":\"Av. Callao 200, C1022AAP CABA, Argentina\"\n                  },\n                  {\n                      \"lat\":\"-34.605648040771484\",\n                      \"lon\":\"-58.39219665527344\",\n                      \"address\":\"Avenida Callao, Sarmiento &, C1025 CABA, Argentina\"\n                  }\n                  ]\n              },\n              \"reference\":\"batransito\",\n              \"creationtime\":\"2020-04-17T17:19:54-03:00\",\n              \"updatetime\":\"2020-04-17T21:27:04-03:00\",\n              \"starttime\":\"2020-04-17T17:19:54-03:00\",\n              \"endtime\":\"2020-04-18T17:19:54-03:00\"\n          }\n      ]\n  }",
          "type": "json"
        }
      ]
    },
    "sampleRequest": [
      {
        "url": "http://sip1.verzi.com.ar/transito/api/v1.0/cortes"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Error",
            "description": "<p>Posible error.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (ejemplo):",
          "content": "HTTP/1.1 500 Internal Server Error\n{\n    status: 500,\n    developerMessage: \"Required query parameter XXXXX not specified (org.mule.module.apikit.exception.InvalidQueryParameterException).\",\n    userMessage: \"Servicio no disponible. Por favor, intente nuevamente más tarde. Muchas gracias.\",\n    errorCode: \"\",\n    moreInfo: \"\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "cronito/plugins/transito/src/Controller/CortesController.php",
    "groupTitle": "Transito"
  },
  {
    "type": "get",
    "url": "/transito/api/v1.0/eventos",
    "title": "Eventos",
    "version": "1.0.0",
    "name": "IndexEventos",
    "group": "Transito",
    "description": "<p>Retorna los eventos, posiblemente no programados, en el tránsito.<br/></p>",
    "parameter": {
      "fields": {
        "Query string": [
          {
            "group": "Query string",
            "type": "String",
            "optional": true,
            "field": "sort",
            "description": "<p>Permite ordenar por un campo (del primer nivel) de forma ascendente o descendente. Para ordenar de forma descendente se debe poner como prefijo del campo un -</p> <pre class=\"prettyprint\">?sort=id (orden ascendente por campo id) </code></pre> <pre class=\"prettyprint\">?sort=-id (orden descendente por campo id) </code></pre>"
          },
          {
            "group": "Query string",
            "type": "String",
            "optional": true,
            "field": "limit",
            "description": "<p>Indica la cantidad máxima de elementos a retornar.</p> <pre class=\"prettyprint\">?limit=5 </code></pre>"
          },
          {
            "group": "Query string",
            "type": "String",
            "optional": true,
            "field": "offset",
            "description": "<p>Indica desde que posición se entregarán los elementos.</p> <pre class=\"prettyprint\">?offset=10 </code></pre>"
          },
          {
            "group": "Query string",
            "type": "String",
            "optional": true,
            "field": "month",
            "description": "<p>Año y mes del cual pediremos la información. El formato esperado es YYYY-MM (Ej.: 2019-12)</p> <pre class=\"prettyprint\">?month=2019-12 </code></pre>"
          },
          {
            "group": "Query string",
            "type": "String",
            "optional": false,
            "field": "provider",
            "description": "<p>Proveedor de datos. Podemos elegir: <ul><li><strong>1</strong>: BA Tránsito</li><li><strong>201</strong>: Transporte Público</li><li><strong>769</strong>: Accidentes Observatorio Seguridad Vial (sólo históricos)</li></ul></p> <pre class=\"prettyprint\">?provider=1 </code></pre>"
          }
        ]
      }
    },
    "examples": [
      {
        "title": "Ejemplo de uso:",
        "content": "GET /transito/api/v1.0/eventos HTTP/1.1\nHost: sip1.verzi.com.ar\nCache-Control: no-cache",
        "type": "json"
      }
    ],
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "GET 'http://sip1.verzi.com.ar/transito/api/v1.0/eventos?provider=1&offset=0&limit=1'\nHTTP/1.1 200 Ok\n\n  {\n      \"metadata\":{\n          \"resultset\":{\n              \"count\":1,\n              \"offset\":0,\n              \"limit\":1\n          }\n      },\n      \"results\":[\n          {\n              \"code\":\"2197622\",\n              \"division\":\"BA\",\n              \"type\":\"Emergencia\",\n              \"subtypeCodes\":\"2262\",\n              \"subtypeNames\":\"Incendio\",\n              \"status\":\"Terminado\",\n              \"organization\":\"BA\",\n              \"userName\":\"Facundo Drucaroff\",\n              \"description\":\"Buenos Aires: Debido a Incendio en Área Buenos Aires en GREGORIO DE LAFERRERE (N) en AV. ESCALADA\",\n              \"impact\":\"Menor\",\n              \"numAffectedLanes\":0,\n              \"article\":\"en\",\n              \"nodeFromCode\":\"1_-34.654797+-58.482655\",\n              \"networkPointFromCode\":\"1572538073827\",\n              \"networkPointFromName\":\"GREGORIO DE LAFERRERE @ AV. ESCALADA\",\n              \"networkPointFromType\":\"Nodo\",\n              \"networkPointFromLinkCode\":\"1_-525489_0\",\n              \"networkPointFromLinkName\":\"GREGORIO DE LAFERRERE\",\n              \"networkPointFromRoadWayCode\":\"1_1.30651973634\",\n              \"networkPointFromRoadWayName\":\"GREGORIO DE LAFERRERE (N)\",\n              \"fromLat\":-34.6547966003418,\n              \"fromLon\":-58.4826545715332,\n              \"createTimestamp\":\"2020-05-01T23:34:36\",\n              \"openTimestamp\":\"2020-05-01T23:34:36\",\n              \"updateTimestamp\":\"2020-05-02T01:36:23\",\n              \"statusTimestamp\":\"2020-05-02T01:36:23\",\n              \"startTimestamp\":\"2020-05-01T23:34:46\",\n              \"endTimestamp\":\"2020-05-02T01:36:23\",\n              \"notifierType\":\"CGM\",\n              \"numPeopleInvolved\":0,\n              \"seriouslyInjuredPeople\":0,\n              \"minorInjuredPeople\":0,\n              \"uninjuredPeople\":0,\n              \"casualtiesPeople\":0,\n              \"numVehicleInvolved\":0,\n              \"lightVehicle\":0,\n              \"heavyVehicle\":0,\n              \"otherVehicle\":0,\n              \"totalLanes\":0\n          }\n      ]\n  }",
          "type": "json"
        }
      ]
    },
    "sampleRequest": [
      {
        "url": "http://sip1.verzi.com.ar/transito/api/v1.0/eventos"
      }
    ],
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "Error",
            "description": "<p>Posible error.</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (ejemplo):",
          "content": "HTTP/1.1 500 Internal Server Error\n{\n    status: 500,\n    developerMessage: \"Required query parameter XXXXX not specified (org.mule.module.apikit.exception.InvalidQueryParameterException).\",\n    userMessage: \"Servicio no disponible. Por favor, intente nuevamente más tarde. Muchas gracias.\",\n    errorCode: \"\",\n    moreInfo: \"\"\n}",
          "type": "json"
        }
      ]
    },
    "filename": "cronito/plugins/transito/src/Controller/EventosController.php",
    "groupTitle": "Transito"
  }
] });
