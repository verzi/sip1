define({ "api": [
  {
    "type": "post",
    "url": "/geometry-library/api/v1.0/poly-utils/containsLocation",
    "title": "containsLocation",
    "version": "1.0.0",
    "name": "containsLocation",
    "group": "PolyUtils",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "point",
            "description": "<p>Punto</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "point.lat",
            "description": "<p>Latitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "point.lon",
            "description": "<p>Longitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Object[]",
            "optional": false,
            "field": "poly",
            "description": "<p>Polilínea</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "poly.lat",
            "description": "<p>Latitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "poly.lon",
            "description": "<p>Longitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": true,
            "field": "geodesic",
            "defaultValue": "false",
            "description": "<p>En geometría, la línea geodésica se define como la línea de mínima longitud que une dos puntos en una superficie dada, y está contenida en esta superficie. El plano osculador de la geodésica es perpendicular en cualquier punto al plano tangente a la superficie. Las geodésicas de una superficie son las líneas &quot;más rectas&quot; posibles (con menor curvatura) fijado un punto y una dirección dada sobre dicha superficie.</p>"
          }
        ]
      }
    },
    "description": "<p>Calcula si el punto dado se encuentra dentro del polígono especificado. El polígono siempre se considera cerrado, independientemente de si el último punto es igual al primero o no. El interior se define como que no contiene el Polo Sur. El Polo Sur siempre está afuera. El polígono está formado por segmentos de gran círculo si la geodésica es verdadera, y de segmentos de rumbo (loxodrómico) de lo contrario.</p>",
    "examples": [
      {
        "title": "Ejemplo de uso:",
        "content": "{\n    \"point\": {\n        \"lat\": \"-34.606788635253906\",\n        \"lon\": \"-58.39219665527344\"\n    },\n    \"poly\": [\n        {\n            \"lat\": \"-34.606788635253906\",\n            \"lon\": \"-58.39211654663086\"\n        },\n        {\n            \"lat\": \"-34.60663986206055\",\n            \"lon\": \"-58.39212417602539\"\n        },\n        {\n            \"lat\": \"-34.605648040771484\",\n            \"lon\": \"-58.39219665527344\"\n        }\n    ]\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "results",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "results.containsLocation",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK \n  {\n      \"results\": {\n          \"containsLocation\": false\n      }\n  }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UnprocessableEntity",
            "description": "<p>Unprocessable Entity</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "MethodNotAllowed",
            "description": "<p>Method Not Allowed</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (Unprocessable Entity):",
          "content": "HTTP/1.1 422 Unprocessable Entity\n  {\n      \"status\": 422,\n      \"developerMessage\": \"Unprocessable Entity\",\n      \"userMessage\": \"Unprocessable Entity\",\n      \"errorCode\": 422,\n      \"moreInfo\": \"\"\n  }",
          "type": "json"
        },
        {
          "title": "Response (Method Not Allowed):",
          "content": "HTTP/1.1 405 Unprocessable Entity\n  {\n      \"status\": 405,\n      \"developerMessage\": \"Method Not Allowed\",\n      \"userMessage\": \"Method Not Allowed\",\n      \"errorCode\": 405,\n      \"moreInfo\": \"\"\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "cronito/plugins/GeometryLibrary/src/Controller/PolyUtilsController.php",
    "groupTitle": "PolyUtils"
  },
  {
    "type": "post",
    "url": "/geometry-library/api/v1.0/poly-utils/decode",
    "title": "decode",
    "version": "1.0.0",
    "name": "decode",
    "group": "PolyUtils",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "encode",
            "description": "<p>Cadena de ruta codificada</p>"
          }
        ]
      }
    },
    "description": "<p>Decodifica una cadena de ruta codificada en una secuencia de puntos (latitudes y longitudes).</p>",
    "examples": [
      {
        "title": "Ejemplo de uso:",
        "content": "{\n    \"encode\": \"lcfrEvukcJ]?eobEN~|hQ?_seK?_glW?\"\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "results",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Object[]",
            "optional": false,
            "field": "results.decode",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "results.decode.lat",
            "description": "<p>Latitud</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "results.decode.lon",
            "description": "<p>Longitud</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK \n  {\n      \"results\": {\n          \"decode\": [\n            {\n                \"lat\": \"-34.606788635253906\",\n                \"lon\": \"-58.39211654663086\"\n            },\n            {\n                \"lat\": \"-34.60663986206055\",\n                \"lon\": \"-58.39212417602539\"\n            },\n            {\n                \"lat\": \"-34.605648040771484\",\n                \"lon\": \"-58.39219665527344\"\n            }\n          ]\n      }\n  }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UnprocessableEntity",
            "description": "<p>Unprocessable Entity</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "MethodNotAllowed",
            "description": "<p>Method Not Allowed</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (Unprocessable Entity):",
          "content": "HTTP/1.1 422 Unprocessable Entity\n  {\n      \"status\": 422,\n      \"developerMessage\": \"Unprocessable Entity\",\n      \"userMessage\": \"Unprocessable Entity\",\n      \"errorCode\": 422,\n      \"moreInfo\": \"\"\n  }",
          "type": "json"
        },
        {
          "title": "Response (Method Not Allowed):",
          "content": "HTTP/1.1 405 Unprocessable Entity\n  {\n      \"status\": 405,\n      \"developerMessage\": \"Method Not Allowed\",\n      \"userMessage\": \"Method Not Allowed\",\n      \"errorCode\": 405,\n      \"moreInfo\": \"\"\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "cronito/plugins/GeometryLibrary/src/Controller/PolyUtilsController.php",
    "groupTitle": "PolyUtils"
  },
  {
    "type": "post",
    "url": "/geometry-library/api/v1.0/poly-utils/distanceToLine",
    "title": "distanceToLine",
    "version": "1.0.0",
    "name": "distanceToLine",
    "group": "PolyUtils",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "point",
            "description": "<p>Punto</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "point.lat",
            "description": "<p>Latitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "point.lon",
            "description": "<p>Longitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "from",
            "description": "<p>Desde</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "from.lat",
            "description": "<p>Latitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "from.lon",
            "description": "<p>Longitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "to",
            "description": "<p>Hasta</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "to.lat",
            "description": "<p>Latitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "to.lon",
            "description": "<p>Longitud</p>"
          }
        ]
      }
    },
    "description": "<p>Calcula la distancia en la esfera entre el punto point y el segmento de línea de from a to.</p>",
    "examples": [
      {
        "title": "Ejemplo de uso:",
        "content": "{\n    \"point\":{\n        \"lat\":\"-34.605499\",\n        \"lon\":\"-58.390765\"\n    },\n    \"from\":{\n        \"lat\":\"-34.605738\",\n        \"lon\":\"-58.393769\"\n    },\n    \"to\":{\n        \"lat\":\"-34.605738\",\n        \"lon\":\"-58.393769\"\n    }\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "results",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "results.distanceToLine",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "results.distanceToLine.distance",
            "description": "<p>Distancia</p>"
          },
          {
            "group": "Success 200",
            "type": "String",
            "allowedValues": [
              "\"m\"",
              "\"km\""
            ],
            "optional": false,
            "field": "results.distanceToLine.unit",
            "description": "<p>Unidad de medida. Puede ser &quot;m&quot; para metros y &quot;km&quot; para kilómetros</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK \n  {\n      \"results\": {\n          \"distanceToLine\": {\n              \"distance\": 276.2151053896317,\n              \"unit\": \"m\"\n          }\n      }\n  }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UnprocessableEntity",
            "description": "<p>Unprocessable Entity</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "MethodNotAllowed",
            "description": "<p>Method Not Allowed</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (Unprocessable Entity):",
          "content": "HTTP/1.1 422 Unprocessable Entity\n  {\n      \"status\": 422,\n      \"developerMessage\": \"Unprocessable Entity\",\n      \"userMessage\": \"Unprocessable Entity\",\n      \"errorCode\": 422,\n      \"moreInfo\": \"\"\n  }",
          "type": "json"
        },
        {
          "title": "Response (Method Not Allowed):",
          "content": "HTTP/1.1 405 Unprocessable Entity\n  {\n      \"status\": 405,\n      \"developerMessage\": \"Method Not Allowed\",\n      \"userMessage\": \"Method Not Allowed\",\n      \"errorCode\": 405,\n      \"moreInfo\": \"\"\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "cronito/plugins/GeometryLibrary/src/Controller/PolyUtilsController.php",
    "groupTitle": "PolyUtils"
  },
  {
    "type": "post",
    "url": "/geometry-library/api/v1.0/poly-utils/encode",
    "title": "encode",
    "version": "1.0.0",
    "name": "encode",
    "group": "PolyUtils",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Object[]",
            "optional": false,
            "field": "poly",
            "description": "<p>Polilínea</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "poly.lat",
            "description": "<p>Latitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "poly.lon",
            "description": "<p>Longitud</p>"
          }
        ]
      }
    },
    "description": "<p>Codifica una secuencia de puntos (latitudes y longitudes) en una cadena de ruta codificada.</p>",
    "examples": [
      {
        "title": "Ejemplo de uso:",
        "content": "{\n    \"poly\": [\n        {\n            \"lat\": \"-34.606788635253906\",\n            \"lon\": \"-58.39211654663086\"\n        },\n        {\n            \"lat\": \"-34.60663986206055\",\n            \"lon\": \"-58.39212417602539\"\n        },\n        {\n            \"lat\": \"-34.605648040771484\",\n            \"lon\": \"-58.39219665527344\"\n        }\n    ]\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "results",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "results.encode",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK \n  {\n      \"results\": {\n          \"endode\": \"lcfrEvukcJ]?eEN\"\n      }\n  }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UnprocessableEntity",
            "description": "<p>Unprocessable Entity</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "MethodNotAllowed",
            "description": "<p>Method Not Allowed</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (Unprocessable Entity):",
          "content": "HTTP/1.1 422 Unprocessable Entity\n  {\n      \"status\": 422,\n      \"developerMessage\": \"Unprocessable Entity\",\n      \"userMessage\": \"Unprocessable Entity\",\n      \"errorCode\": 422,\n      \"moreInfo\": \"\"\n  }",
          "type": "json"
        },
        {
          "title": "Response (Method Not Allowed):",
          "content": "HTTP/1.1 405 Unprocessable Entity\n  {\n      \"status\": 405,\n      \"developerMessage\": \"Method Not Allowed\",\n      \"userMessage\": \"Method Not Allowed\",\n      \"errorCode\": 405,\n      \"moreInfo\": \"\"\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "cronito/plugins/GeometryLibrary/src/Controller/PolyUtilsController.php",
    "groupTitle": "PolyUtils"
  },
  {
    "type": "post",
    "url": "/geometry-library/api/v1.0/poly-utils/isLocationOnEdge",
    "title": "isLocationOnEdge",
    "version": "1.0.0",
    "name": "isLocationOnEdge",
    "group": "PolyUtils",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "point",
            "description": "<p>Punto</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "point.lat",
            "description": "<p>Latitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "point.lon",
            "description": "<p>Longitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Object[]",
            "optional": false,
            "field": "poly",
            "description": "<p>Polilínea</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "poly.lat",
            "description": "<p>Latitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "poly.lon",
            "description": "<p>Longitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "tolerance",
            "defaultValue": "0.1",
            "description": "<p>Valor de tolerancia en metros</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": true,
            "field": "geodesic",
            "defaultValue": "true",
            "description": "<p>En geometría, la línea geodésica se define como la línea de mínima longitud que une dos puntos en una superficie dada, y está contenida en esta superficie. El plano osculador de la geodésica es perpendicular en cualquier punto al plano tangente a la superficie. Las geodésicas de una superficie son las líneas &quot;más rectas&quot; posibles (con menor curvatura) fijado un punto y una dirección dada sobre dicha superficie.</p>"
          }
        ]
      }
    },
    "description": "<p>Calcula si el punto dado se encuentra en o cerca del borde de un polígono, dentro de una tolerancia especificada en metros. El borde del polígono se compone de grandes segmentos circulares si la geodésica es verdadera, y de segmentos Rhumb de lo contrario. El borde del polígono está implícitamente cerrado. Se incluye el segmento de cierre entre el primer punto y el último punto.</p>",
    "examples": [
      {
        "title": "Ejemplo de uso:",
        "content": "{\n    \"point\": {\n        \"lat\": \"-34.606788635253906\",\n        \"lon\": \"-58.39219665527344\"\n    },\n    \"poly\": [\n        {\n            \"lat\": \"-34.606788635253906\",\n            \"lon\": \"-58.39211654663086\"\n        },\n        {\n            \"lat\": \"-34.60663986206055\",\n            \"lon\": \"-58.39212417602539\"\n        },\n        {\n            \"lat\": \"-34.605648040771484\",\n            \"lon\": \"-58.39219665527344\"\n        }\n    ]\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "results",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "results.isLocationOnEdge",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK \n  {\n      \"results\": {\n          \"isLocationOnEdge\": false\n      }\n  }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UnprocessableEntity",
            "description": "<p>Unprocessable Entity</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "MethodNotAllowed",
            "description": "<p>Method Not Allowed</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (Unprocessable Entity):",
          "content": "HTTP/1.1 422 Unprocessable Entity\n  {\n      \"status\": 422,\n      \"developerMessage\": \"Unprocessable Entity\",\n      \"userMessage\": \"Unprocessable Entity\",\n      \"errorCode\": 422,\n      \"moreInfo\": \"\"\n  }",
          "type": "json"
        },
        {
          "title": "Response (Method Not Allowed):",
          "content": "HTTP/1.1 405 Unprocessable Entity\n  {\n      \"status\": 405,\n      \"developerMessage\": \"Method Not Allowed\",\n      \"userMessage\": \"Method Not Allowed\",\n      \"errorCode\": 405,\n      \"moreInfo\": \"\"\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "cronito/plugins/GeometryLibrary/src/Controller/PolyUtilsController.php",
    "groupTitle": "PolyUtils"
  },
  {
    "type": "post",
    "url": "/geometry-library/api/v1.0/poly-utils/isLocationOnPath",
    "title": "isLocationOnPath",
    "version": "1.0.0",
    "name": "isLocationOnPath",
    "group": "PolyUtils",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "point",
            "description": "<p>Punto</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "point.lat",
            "description": "<p>Latitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "point.lon",
            "description": "<p>Longitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Object[]",
            "optional": false,
            "field": "poly",
            "description": "<p>Polilínea</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "poly.lat",
            "description": "<p>Latitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "poly.lon",
            "description": "<p>Longitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": true,
            "field": "tolerance",
            "defaultValue": "0.1",
            "description": "<p>Valor de tolerancia en metros</p>"
          },
          {
            "group": "Parameter",
            "type": "Boolean",
            "optional": true,
            "field": "geodesic",
            "defaultValue": "true",
            "description": "<p>En geometría, la línea geodésica se define como la línea de mínima longitud que une dos puntos en una superficie dada, y está contenida en esta superficie. El plano osculador de la geodésica es perpendicular en cualquier punto al plano tangente a la superficie. Las geodésicas de una superficie son las líneas &quot;más rectas&quot; posibles (con menor curvatura) fijado un punto y una dirección dada sobre dicha superficie.</p>"
          }
        ]
      }
    },
    "description": "<p>Calcula si el punto dado se encuentra en o cerca de una polilínea, dentro de una tolerancia especificada en metros. La polilínea se compone de grandes segmentos circulares si la geodésica es verdadera, y de segmentos Rhumb de lo contrario. La polilínea no está cerrada. El segmento de cierre entre el primer punto y el último punto no está incluido.</p>",
    "examples": [
      {
        "title": "Ejemplo de uso:",
        "content": "{\n    \"point\": {\n        \"lat\": \"-34.606788635253906\",\n        \"lon\": \"-58.39219665527344\"\n    },\n    \"poly\": [\n        {\n            \"lat\": \"-34.606788635253906\",\n            \"lon\": \"-58.39211654663086\"\n        },\n        {\n            \"lat\": \"-34.60663986206055\",\n            \"lon\": \"-58.39212417602539\"\n        },\n        {\n            \"lat\": \"-34.605648040771484\",\n            \"lon\": \"-58.39219665527344\"\n        }\n    ]\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "results",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "results.isLocationOnPath",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK \n  {\n      \"results\": {\n          \"isLocationOnPath\": false\n      }\n  }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UnprocessableEntity",
            "description": "<p>Unprocessable Entity</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "MethodNotAllowed",
            "description": "<p>Method Not Allowed</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (Unprocessable Entity):",
          "content": "HTTP/1.1 422 Unprocessable Entity\n  {\n      \"status\": 422,\n      \"developerMessage\": \"Unprocessable Entity\",\n      \"userMessage\": \"Unprocessable Entity\",\n      \"errorCode\": 422,\n      \"moreInfo\": \"\"\n  }",
          "type": "json"
        },
        {
          "title": "Response (Method Not Allowed):",
          "content": "HTTP/1.1 405 Unprocessable Entity\n  {\n      \"status\": 405,\n      \"developerMessage\": \"Method Not Allowed\",\n      \"userMessage\": \"Method Not Allowed\",\n      \"errorCode\": 405,\n      \"moreInfo\": \"\"\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "cronito/plugins/GeometryLibrary/src/Controller/PolyUtilsController.php",
    "groupTitle": "PolyUtils"
  },
  {
    "type": "post",
    "url": "/geometry-library/api/v1.0/spherical-utils/computeArea",
    "title": "computeArea",
    "version": "1.0.0",
    "name": "computeArea",
    "group": "SphericalUtils",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Object[]",
            "optional": false,
            "field": "poly",
            "description": "<p>Polilínea (Un camino cerrado)</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "poly.lat",
            "description": "<p>Latitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "poly.lon",
            "description": "<p>Longitud</p>"
          }
        ]
      }
    },
    "description": "<p>Devuelve el área de un camino cerrado en la Tierra, en metros cuadrados.</p>",
    "examples": [
      {
        "title": "Ejemplo de uso:",
        "content": "{\n  \"poly\": [\n        {\n            \"lat\": \"-34.606788635253906\",\n            \"lon\": \"-58.39211654663086\"\n        },\n        {\n            \"lat\": \"-34.60663986206055\",\n            \"lon\": \"-58.39212417602539\"\n        },\n        {\n            \"lat\": \"-34.605648040771484\",\n            \"lon\": \"-58.39219665527344\"\n        }\n    ]\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "results",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "results.computeArea",
            "description": "<p>Área de un camino cerrado en la Tierra expresada en metros cuadrados</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK \n  {\n      \"results\": {\n          \"computeArea\": 16.364770561952934\n      }\n  }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UnprocessableEntity",
            "description": "<p>Unprocessable Entity</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "MethodNotAllowed",
            "description": "<p>Method Not Allowed</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (Unprocessable Entity):",
          "content": "HTTP/1.1 422 Unprocessable Entity\n  {\n      \"status\": 422,\n      \"developerMessage\": \"Unprocessable Entity\",\n      \"userMessage\": \"Unprocessable Entity\",\n      \"errorCode\": 422,\n      \"moreInfo\": \"\"\n  }",
          "type": "json"
        },
        {
          "title": "Response (Method Not Allowed):",
          "content": "HTTP/1.1 405 Unprocessable Entity\n  {\n      \"status\": 405,\n      \"developerMessage\": \"Method Not Allowed\",\n      \"userMessage\": \"Method Not Allowed\",\n      \"errorCode\": 405,\n      \"moreInfo\": \"\"\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "cronito/plugins/GeometryLibrary/src/Controller/SphericalUtilsController.php",
    "groupTitle": "SphericalUtils"
  },
  {
    "type": "post",
    "url": "/geometry-library/api/v1.0/spherical-utils/computeDistanceBetween",
    "title": "computeDistanceBetween",
    "version": "1.0.0",
    "name": "computeDistanceBetween",
    "group": "SphericalUtils",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "from",
            "description": "<p>El punto Origen</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "from.lat",
            "description": "<p>Latitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "from.lon",
            "description": "<p>Longitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "to",
            "description": "<p>El punto Destino</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "to.lat",
            "description": "<p>Latitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "to.lon",
            "description": "<p>Longitud</p>"
          }
        ]
      }
    },
    "description": "<p>Devuelve la distancia entre dos puntos, en metros.</p>",
    "examples": [
      {
        "title": "Ejemplo de uso:",
        "content": "{\n    \"from\":{\n        \"lat\":\"-34.606788635253906\",\n        \"lon\":\"-58.39211654663086\"\n    },\n    \"to\":{\n        \"lat\":\"-33.606788635253906\",\n        \"lon\":\"-58.39212417602539\"\n    }\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "results",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "results.computeDistanceBetween",
            "description": "<p>Distancia entre los dos puntos expresada en metros</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK \n  {\n      \"results\": {\n          \"computeDistanceBetween\": 111195.08372641008\n      }\n  }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UnprocessableEntity",
            "description": "<p>Unprocessable Entity</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "MethodNotAllowed",
            "description": "<p>Method Not Allowed</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (Unprocessable Entity):",
          "content": "HTTP/1.1 422 Unprocessable Entity\n  {\n      \"status\": 422,\n      \"developerMessage\": \"Unprocessable Entity\",\n      \"userMessage\": \"Unprocessable Entity\",\n      \"errorCode\": 422,\n      \"moreInfo\": \"\"\n  }",
          "type": "json"
        },
        {
          "title": "Response (Method Not Allowed):",
          "content": "HTTP/1.1 405 Unprocessable Entity\n  {\n      \"status\": 405,\n      \"developerMessage\": \"Method Not Allowed\",\n      \"userMessage\": \"Method Not Allowed\",\n      \"errorCode\": 405,\n      \"moreInfo\": \"\"\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "cronito/plugins/GeometryLibrary/src/Controller/SphericalUtilsController.php",
    "groupTitle": "SphericalUtils"
  },
  {
    "type": "post",
    "url": "/geometry-library/api/v1.0/spherical-utils/computeHeading",
    "title": "computeHeading",
    "version": "1.0.0",
    "name": "computeHeading",
    "group": "SphericalUtils",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "from",
            "description": "<p>El punto Origen</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "from.lat",
            "description": "<p>Latitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "from.lon",
            "description": "<p>Longitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "to",
            "description": "<p>El punto Destino</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "to.lat",
            "description": "<p>Latitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "to.lon",
            "description": "<p>Longitud</p>"
          }
        ]
      }
    },
    "description": "<p>Devuelve el encabezado de un Punto a otro Punto. Los encabezados se expresan en grados en sentido horario desde el norte dentro del rango [-180,180).</p>",
    "examples": [
      {
        "title": "Ejemplo de uso:",
        "content": "{\n    \"from\":{\n        \"lat\":\"-34.000000\",\n        \"lon\":\"-59.000000\"\n    },\n    \"to\":{\n        \"lat\":\"-30.000000\",\n        \"lon\":\"-58.000000\"\n    }\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "results",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Boolean",
            "optional": false,
            "field": "results.computeHeading",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK \n  {\n      \"results\": {\n          \"computeHeading\": 12.2379278726376\n      }\n  }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UnprocessableEntity",
            "description": "<p>Unprocessable Entity</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "MethodNotAllowed",
            "description": "<p>Method Not Allowed</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (Unprocessable Entity):",
          "content": "HTTP/1.1 422 Unprocessable Entity\n  {\n      \"status\": 422,\n      \"developerMessage\": \"Unprocessable Entity\",\n      \"userMessage\": \"Unprocessable Entity\",\n      \"errorCode\": 422,\n      \"moreInfo\": \"\"\n  }",
          "type": "json"
        },
        {
          "title": "Response (Method Not Allowed):",
          "content": "HTTP/1.1 405 Unprocessable Entity\n  {\n      \"status\": 405,\n      \"developerMessage\": \"Method Not Allowed\",\n      \"userMessage\": \"Method Not Allowed\",\n      \"errorCode\": 405,\n      \"moreInfo\": \"\"\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "cronito/plugins/GeometryLibrary/src/Controller/SphericalUtilsController.php",
    "groupTitle": "SphericalUtils"
  },
  {
    "type": "post",
    "url": "/geometry-library/api/v1.0/spherical-utils/computeLength",
    "title": "computeLength",
    "version": "1.0.0",
    "name": "computeLength",
    "group": "SphericalUtils",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Object[]",
            "optional": false,
            "field": "poly",
            "description": "<p>Polilínea</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "poly.lat",
            "description": "<p>Latitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "poly.lon",
            "description": "<p>Longitud</p>"
          }
        ]
      }
    },
    "description": "<p>Devuelve la longitud de la ruta dada, en metros, en la Tierra.</p>",
    "examples": [
      {
        "title": "Ejemplo de uso:",
        "content": "{\n  \"poly\": [\n        {\n            \"lat\": \"-34.606788635253906\",\n            \"lon\": \"-58.39211654663086\"\n        },\n        {\n            \"lat\": \"-34.60663986206055\",\n            \"lon\": \"-58.39212417602539\"\n        },\n        {\n            \"lat\": \"-34.605648040771484\",\n            \"lon\": \"-58.39219665527344\"\n        }\n    ]\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "results",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "results.computeLength",
            "description": "<p>Longitud de la ruta dada, en metros, en la Tierra</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK \n  {\n      \"results\": {\n          \"computeLength\": 127.04254201169243\n      }\n  }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UnprocessableEntity",
            "description": "<p>Unprocessable Entity</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "MethodNotAllowed",
            "description": "<p>Method Not Allowed</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (Unprocessable Entity):",
          "content": "HTTP/1.1 422 Unprocessable Entity\n  {\n      \"status\": 422,\n      \"developerMessage\": \"Unprocessable Entity\",\n      \"userMessage\": \"Unprocessable Entity\",\n      \"errorCode\": 422,\n      \"moreInfo\": \"\"\n  }",
          "type": "json"
        },
        {
          "title": "Response (Method Not Allowed):",
          "content": "HTTP/1.1 405 Unprocessable Entity\n  {\n      \"status\": 405,\n      \"developerMessage\": \"Method Not Allowed\",\n      \"userMessage\": \"Method Not Allowed\",\n      \"errorCode\": 405,\n      \"moreInfo\": \"\"\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "cronito/plugins/GeometryLibrary/src/Controller/SphericalUtilsController.php",
    "groupTitle": "SphericalUtils"
  },
  {
    "type": "post",
    "url": "/geometry-library/api/v1.0/spherical-utils/computeOffset",
    "title": "computeOffset",
    "version": "1.0.0",
    "name": "computeOffset",
    "group": "SphericalUtils",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "from",
            "description": "<p>El punto Origen</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "from.lat",
            "description": "<p>Latitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "from.lon",
            "description": "<p>Longitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "distance",
            "description": "<p>La distancia a recorrer, en metros</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "heading",
            "description": "<p>El rumbo en grados en sentido horario desde el norte</p>"
          }
        ]
      }
    },
    "description": "<p>Devuelve el Punto resultante de mover una distancia desde un origen en el rumbo especificado (expresado en grados en sentido horario desde el norte).</p>",
    "examples": [
      {
        "title": "Ejemplo de uso:",
        "content": "{\n    \"from\":{\n        \"lat\":\"-34.000000\",\n        \"lon\":\"-59.000000\"\n    },\n    \"distance\": 150,\n    \"heading\": 0\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "results",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "results.computeOffset",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "results.computeOffset.lat",
            "description": "<p>Latitud</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "results.computeOffset.lon",
            "description": "<p>Longitud</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK \n  {\n      \"results\": {\n          \"computeOffset\": {\n              \"lat\": -33.998651019496755,\n              \"lng\": -58.99999999999999\n          }\n      }\n  }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UnprocessableEntity",
            "description": "<p>Unprocessable Entity</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "MethodNotAllowed",
            "description": "<p>Method Not Allowed</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (Unprocessable Entity):",
          "content": "HTTP/1.1 422 Unprocessable Entity\n  {\n      \"status\": 422,\n      \"developerMessage\": \"Unprocessable Entity\",\n      \"userMessage\": \"Unprocessable Entity\",\n      \"errorCode\": 422,\n      \"moreInfo\": \"\"\n  }",
          "type": "json"
        },
        {
          "title": "Response (Method Not Allowed):",
          "content": "HTTP/1.1 405 Unprocessable Entity\n  {\n      \"status\": 405,\n      \"developerMessage\": \"Method Not Allowed\",\n      \"userMessage\": \"Method Not Allowed\",\n      \"errorCode\": 405,\n      \"moreInfo\": \"\"\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "cronito/plugins/GeometryLibrary/src/Controller/SphericalUtilsController.php",
    "groupTitle": "SphericalUtils"
  },
  {
    "type": "post",
    "url": "/geometry-library/api/v1.0/spherical-utils/computeOffsetOrigin",
    "title": "computeOffsetOrigin",
    "version": "1.0.0",
    "name": "computeOffsetOrigin",
    "group": "SphericalUtils",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "to",
            "description": "<p>El punto Destino</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "to.lat",
            "description": "<p>Latitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "to.lon",
            "description": "<p>Longitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "distance",
            "description": "<p>La distancia a recorrer, en metros</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "heading",
            "description": "<p>El rumbo en grados en sentido horario desde el norte</p>"
          }
        ]
      }
    },
    "description": "<p>Devuelve la ubicación de origen cuando se le proporciona un punto destino, metros recorridos y rumbo original. El campo heading se expresa en grados en sentido horario desde el norte. Esta función devuelve nulo cuando no hay una solución disponible.</p>",
    "examples": [
      {
        "title": "Ejemplo de uso:",
        "content": "{\n    \"to\":{\n        \"lat\":\"-33.998651019496755\",\n        \"lon\":\"-58.99999999999999\"\n    },\n    \"distance\": 150,\n    \"heading\": 0\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "results",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "results.computeOffsetOrigin",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "results.computeOffset.lat",
            "description": "<p>Latitud</p>"
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "results.computeOffset.lon",
            "description": "<p>Longitud</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK \n  {\n      \"results\": {\n          \"computeOffset\": {\n              \"lat\": -10.987548569233995,\n              \"lng\": -193685.57465069287\n          }\n      }\n  }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UnprocessableEntity",
            "description": "<p>Unprocessable Entity</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "MethodNotAllowed",
            "description": "<p>Method Not Allowed</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (Unprocessable Entity):",
          "content": "HTTP/1.1 422 Unprocessable Entity\n  {\n      \"status\": 422,\n      \"developerMessage\": \"Unprocessable Entity\",\n      \"userMessage\": \"Unprocessable Entity\",\n      \"errorCode\": 422,\n      \"moreInfo\": \"\"\n  }",
          "type": "json"
        },
        {
          "title": "Response (Method Not Allowed):",
          "content": "HTTP/1.1 405 Unprocessable Entity\n  {\n      \"status\": 405,\n      \"developerMessage\": \"Method Not Allowed\",\n      \"userMessage\": \"Method Not Allowed\",\n      \"errorCode\": 405,\n      \"moreInfo\": \"\"\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "cronito/plugins/GeometryLibrary/src/Controller/SphericalUtilsController.php",
    "groupTitle": "SphericalUtils"
  },
  {
    "type": "post",
    "url": "/geometry-library/api/v1.0/spherical-utils/interpolate",
    "title": "interpolate",
    "version": "1.0.0",
    "name": "interpolate",
    "group": "SphericalUtils",
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "from",
            "description": "<p>El punto Origen</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "from.lat",
            "description": "<p>Latitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "from.lon",
            "description": "<p>Longitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "to",
            "description": "<p>El punto Destino</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "to.lat",
            "description": "<p>Latitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Number",
            "optional": false,
            "field": "to.lon",
            "description": "<p>Longitud</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "fraction",
            "description": "<p>Una fracción de la distancia a recorrer</p>"
          }
        ]
      }
    },
    "description": "<p>Devuelve el Punto que se encuentra la fracción dada del camino entre el Punto de origen y el Punto de destino.</p>",
    "examples": [
      {
        "title": "Ejemplo de uso:",
        "content": "{\n    \"from\":{\n        \"lat\":\"-34.606788635253906\",\n        \"lon\":\"-58.39211654663086\"\n    },\n    \"to\":{\n        \"lat\":\"-33.606788635253906\",\n        \"lon\":\"-58.39212417602539\"\n    },\n    \"fraction\": 5\n}",
        "type": "json"
      }
    ],
    "success": {
      "fields": {
        "Success 200": [
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "results",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Object",
            "optional": false,
            "field": "results.interpolate",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "results.interpolate.lat",
            "description": ""
          },
          {
            "group": "Success 200",
            "type": "Number",
            "optional": false,
            "field": "results.interpolate.lon",
            "description": ""
          }
        ]
      },
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK \n  {\n      \"results\": {\n          \"interpolate\": {\n              \"lat\": -29.6067886352496,\n              \"lon\": -58.39215304409501\n          }\n      }\n  }",
          "type": "json"
        }
      ]
    },
    "error": {
      "fields": {
        "Error 4xx": [
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "UnprocessableEntity",
            "description": "<p>Unprocessable Entity</p>"
          },
          {
            "group": "Error 4xx",
            "optional": false,
            "field": "MethodNotAllowed",
            "description": "<p>Method Not Allowed</p>"
          }
        ]
      },
      "examples": [
        {
          "title": "Response (Unprocessable Entity):",
          "content": "HTTP/1.1 422 Unprocessable Entity\n  {\n      \"status\": 422,\n      \"developerMessage\": \"Unprocessable Entity\",\n      \"userMessage\": \"Unprocessable Entity\",\n      \"errorCode\": 422,\n      \"moreInfo\": \"\"\n  }",
          "type": "json"
        },
        {
          "title": "Response (Method Not Allowed):",
          "content": "HTTP/1.1 405 Unprocessable Entity\n  {\n      \"status\": 405,\n      \"developerMessage\": \"Method Not Allowed\",\n      \"userMessage\": \"Method Not Allowed\",\n      \"errorCode\": 405,\n      \"moreInfo\": \"\"\n  }",
          "type": "json"
        }
      ]
    },
    "filename": "cronito/plugins/GeometryLibrary/src/Controller/SphericalUtilsController.php",
    "groupTitle": "SphericalUtils"
  }
] });
