<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'Transito',
    ['path' => '/transito'],
    function (RouteBuilder $routes) {
        /** 
        * API V1.0
        */
        $routes->scope('/api/v1.0', ['_namePrefix' => 'apiv10:'], function ($routes) {
            
            $routes->extensions(['json','xml']);
            
            $routes->resources('Cortes');
            $routes->resources('Eventos');

            $routes->fallbacks(DashedRoute::class);
        });

    }
);