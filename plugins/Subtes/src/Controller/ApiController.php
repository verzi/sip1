<?php
namespace Subtes\Controller;

use App\Controller\ApiController as MainApiController;
use Cake\Network\Http\Client;
use Cake\Event\Event;
use Cake\Core\Configure;

class ApiController extends MainApiController
{
    public function setApiData(){
        $host = 'apitransporte.buenosaires.gob.ar/subtes';
        $scheme = 'https';

        $this->http = new Client([
            'host' => $host,
            'scheme' => $scheme,
            'ssl_verify_host' => false,
            'ssl_verify_peer' => false,
            'ssl_verify_peer_name' => false,
        ]);
    }
}