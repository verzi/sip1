<?php

return [
    'ApiRequest' => [
        'debug' => true,
        'responseFormat' => [
            'statusKey' => 'status',
            'statusOkText' => 200,
            'statusNokText' => 400,
            'resultKey' => 'results',
            'messageKey' => 'message',
            'defaultMessageText' => '',
            'errorKey' => 'error',
            'defaultErrorText' => 'Unknown request!',
            /**
             * Lo que sigue se agrega para cumplir el estándar
             *
             * @see  https://github.com/argob/estandares/blob/master/estandares-apis.md#manejo-de-errores
             */
            'developerMessage' => '',
            'userMessage' => '',
            'errorCode' => '',
            'moreInfo' => ''
        ],
        'log' => false,
        'jwtAuth' => [
            'enabled' => false,
            'cypherKey' => '...',
            'tokenAlgorithm' => 'HS256'
        ],
        'cors' => [
            'enabled' => true,
            'origin' => ['*'],
            'allowedMethods' => ['GET', 'POST', 'OPTIONS'],
            'allowedHeaders' => ['Content-Type, Authorization, Accept, Origin'],
            'maxAge' => 2628000
        ],
        'routing' => []
    ]
];
