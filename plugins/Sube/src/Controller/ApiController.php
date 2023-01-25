<?php
namespace Sube\Controller;

use App\Controller\ApiController as MainApiController;
use Cake\Network\Http\Client;
use Cake\Event\Event;
use Cake\Core\Configure;

class ApiController extends MainApiController
{
    public function initialize() {
        parent::initialize();
        putenv("GOOGLE_APPLICATION_CREDENTIALS=".CONFIG."sip1-fcbaa-0a907f5ca7df.json");
    }
    public function setApiData(){
    }
}