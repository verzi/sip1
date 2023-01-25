define({ "api": [
  {
    "type": "get",
    "url": "/monopatines/api/v1.0/glovo",
    "title": "Glovo",
    "version": "1.0.0",
    "name": "IndexGlovo",
    "group": "Monopatines",
    "description": "<p>Retorna los monopatines de la empresa Glovo.<br/></p>",
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
        "content": "GET /monopatines/api/v1.0/glovo HTTP/1.1\nHost: sip1.verzi.com.ar\nCache-Control: no-cache",
        "type": "json"
      }
    ],
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "GET 'http://sip1.verzi.com.ar/monopatines/api/v1.0/glovo?offset=0&limit=1'\nHTTP/1.1 200 Ok\n\n  {\n      \"metadata\":{\n          \"resultset\":{\n              \"count\":1,\n              \"offset\":0,\n              \"limit\":1\n          }\n      },\n      \"results\":[\n          {\n              \"bike_id\":\"G1136\",\n              \"lat\":-34.5871423333333,\n              \"lon\":-58.4103471666667,\n              \"is_reserved\":0,\n              \"is_disabled\":1\n          }\n      ]\n  }",
          "type": "json"
        }
      ]
    },
    "sampleRequest": [
      {
        "url": "http://sip1.verzi.com.ar/monopatines/api/v1.0/glovo"
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
    "filename": "cronito/plugins/monopatines/src/Controller/GlovoController.php",
    "groupTitle": "Monopatines"
  },
  {
    "type": "get",
    "url": "/monopatines/api/v1.0/grin",
    "title": "Grin",
    "version": "1.0.0",
    "name": "IndexGrin",
    "group": "Monopatines",
    "description": "<p>Retorna los monopatines de la empresa Grin.<br/></p>",
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
        "content": "GET /monopatines/api/v1.0/grin HTTP/1.1\nHost: sip1.verzi.com.ar\nCache-Control: no-cache",
        "type": "json"
      }
    ],
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "GET 'http://sip1.verzi.com.ar/monopatines/api/v1.0/grin?offset=0&limit=1'\nHTTP/1.1 200 Ok\n\n  {\n      \"metadata\":{\n          \"resultset\":{\n              \"count\":1,\n              \"offset\":0,\n              \"limit\":1\n          }\n      },\n      \"results\":[\n          {\n              \"bike_id\":1225067,\n              \"lat\":-34.5871423333333,\n              \"lon\":-58.4103471666667,\n              \"is_reserved\":0,\n              \"is_disabled\":0\n          }\n      ]\n  }",
          "type": "json"
        }
      ]
    },
    "sampleRequest": [
      {
        "url": "http://sip1.verzi.com.ar/monopatines/api/v1.0/grin"
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
    "filename": "cronito/plugins/monopatines/src/Controller/GrinController.php",
    "groupTitle": "Monopatines"
  },
  {
    "type": "get",
    "url": "/monopatines/api/v1.0/movo",
    "title": "Movo",
    "version": "1.0.0",
    "name": "IndexMovo",
    "group": "Monopatines",
    "description": "<p>Retorna los monopatines de la empresa Movo.<br/></p>",
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
        "content": "GET /monopatines/api/v1.0/movo HTTP/1.1\nHost: sip1.verzi.com.ar\nCache-Control: no-cache",
        "type": "json"
      }
    ],
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "GET 'http://sip1.verzi.com.ar/monopatines/api/v1.0/movo?offset=0&limit=1'\nHTTP/1.1 200 Ok\n\n  {\n      \"metadata\":{\n          \"resultset\":{\n              \"count\":1,\n              \"offset\":0,\n              \"limit\":1\n          }\n      },\n      \"results\":[\n          {\n              \"bike_id\":\"M#AA2401\",\n              \"lat\":-34.5871423333333,\n              \"lon\":-58.4103471666667,\n              \"is_reserved\":0,\n              \"is_disabled\":1\n          }\n      ]\n  }",
          "type": "json"
        }
      ]
    },
    "sampleRequest": [
      {
        "url": "http://sip1.verzi.com.ar/monopatines/api/v1.0/movo"
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
    "filename": "cronito/plugins/monopatines/src/Controller/MovoController.php",
    "groupTitle": "Monopatines"
  }
] });
