<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'GeometryLibrary',
    ['path' => '/geometry-library'],
    function (RouteBuilder $routes) {
        /** 
        * API V1.0
        */
        $routes->scope('/api/v1.0', ['_namePrefix' => 'apiv10:'], function ($routes) {
            
            $routes->extensions(['json','xml']);

            $routes->resources('PolyUtils',[
                'inflect' => 'dasherize'
            ]);

            $routes->fallbacks(DashedRoute::class);
        });
        $routes->fallbacks(DashedRoute::class);
    }
);
