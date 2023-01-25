define({ "api": [
  {
    "type": "get",
    "url": "/subtes/api/v1.0/service-alerts",
    "title": "Service Alerts",
    "version": "1.0.0",
    "name": "IndexSubtes",
    "group": "Subtes",
    "description": "<p>Retorna las alertas de servicio de subtes.<br/></p>",
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
        "content": "GET /subtes/api/v1.0/service-alerts HTTP/1.1\nHost: sip1.verzi.com.ar\nCache-Control: no-cache",
        "type": "json"
      }
    ],
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "GET 'http://sip1.verzi.com.ar/subtes/api/v1.0/service-alerts?offset=0&limit=1'\nHTTP/1.1 200 Ok\n\n  {\n      \"metadata\":{\n          \"resultset\":{\n              \"count\":1,\n              \"offset\":0,\n              \"limit\":1\n          }\n      },\n      \"results\":[\n          {\n              \"id\":\"Alert_LineaA\",\n              \"is_deleted\":false,\n              \"trip_update\":null,\n              \"vehicle\":null,\n              \"alert\":{\n                  \"active_period\":[\n\n                  ],\n                  \"informed_entity\":[\n                  {\n                      \"agency_id\":\"\",\n                      \"route_id\":\"LineaA\",\n                      \"route_type\":0,\n                      \"trip\":null,\n                      \"stop_id\":\"\"\n                  }\n                  ],\n                  \"cause\":12,\n                  \"effect\":6,\n                  \"url\":null,\n                  \"header_text\":{\n                  \"translation\":[\n                      {\n                          \"text\":\"Por protocolo de prevención: circula con un servicio especial. Info www.metrovias.com.ar\",\n                          \"language\":\"es\"\n                      }\n                  ]\n                  },\n                  \"description_text\":{\n                  \"translation\":[\n                      {\n                          \"text\":\"Por protocolo de prevención: circula con un servicio especial. Info www.metrovias.com.ar\",\n                          \"language\":\"es\"\n                      }\n                  ]\n                  },\n                  \"cause_original_text\":\"MEDICAL_EMERGENCY\",\n                  \"cause_translation_text\":\"Emergencia médica\",\n                  \"effect_original_text\":\"MODIFIED_SERVICE\",\n                  \"effect_translation_text\":\"Modificación en servicio\"\n              }\n          }\n      ]\n  }",
          "type": "json"
        }
      ]
    },
    "sampleRequest": [
      {
        "url": "http://sip1.verzi.com.ar/subtes/api/v1.0/service-alerts"
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
    "filename": "cronito/plugins/subtes/src/Controller/ServiceAlertsController.php",
    "groupTitle": "Subtes"
  }
] });
