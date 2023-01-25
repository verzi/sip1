<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class PatovaComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'enabled' => true,
        /**
         * Cantidad máxima de request
         */
        'rate_limit_limit' => 200,
        /**
         * Cantidad de segundos considerados a tomar en cuenta para validar la regla del rate limit.
         * Por ejemplo, si rate_limit_window = 3600 y rate_limit_limit = 250 significa que
         * se podrán hacer 250 peticiones por hora desde una misma IP.
         */
        'rate_limit_window' => 3600,
        /**
         * Cantidad de segundos considerados a tomar en cuenta para validar la regla del rate limit respecto al último registro.
         * Por ejemplo, si rate_limit_window_last_record = 150 significa que deberán pasar 2,5 minutos para insertar o actualizar 
         * un registro desde una misma IP.
         */
        'rate_limit_window_last_record' => 0,
        /**
         * Acciones que se tendran en cuenta para el component.
         * Si se deja vacio el array se aplica a todo el recurso.
         */
        'actions' => []
    ];
    
    /**
     * The controller.
     *
     * @var \Cake\Controller\Controller
     */
    private $Controller = null;

    /**
     * The HttpRequests Model.
     *
     * @var \Cake\Controller\Controller
     */
    private $HttpRequestsModel = null;


    /**
     * startup.
     *
     * Startup callback for Components.
     *
     * @param \Cake\Event\Event $event Event.
     * @return void
     */
    public function startup($event)
    {
        $this->setController($event->subject());
    }

    /**
     * initialize
     *
     * Initialize callback for Components.
     *
     * @param array $config Configurations.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->Controller = $this->_registry->getController();
        $this->HttpRequestsModel = TableRegistry::get('HttpRequests'); 
    }

    /**
     * setController
     *
     * Setter for the Controller property.
     *
     * @param \Cake\Controller\Controller $controller Controller.
     * @return void
     */
    public function setController($controller)
    {
        $this->Controller = $controller;
    }

    public function beforeFilter($event){

        if ( (bool) $this->getConfig()['enabled'] ){

            $this->response = $this->getPatovaResponseAttributes($this->response);

            if ( !$this->validateRules() ){
                $this->response = $this->getResponseTooManyRequests($this->response);
                return $this->response;
            }

            /**
             * Si pasó todas las reglas de validación, registro el request... 
             */

            $httprequest = $this->HttpRequestsModel->newEntity();
            $httprequest->ip = $this->Controller->request->clientIp();
            $httprequest->plugin = $this->Controller->request->params['plugin'];
            $httprequest->controller = $this->Controller->request->params['controller'];
            $httprequest->action = $this->Controller->request->params['action'];
            $this->HttpRequestsModel->save($httprequest);
        }
    }

    protected function getPatovaResponseAttributes( $response ){
        $httpRequestsDone = $this->getCountRateLimit();
        $rateLimitLimit = isset($this->getConfig()['actions'][$this->Controller->request->params['action']]['rate_limit_limit']) ? $this->getConfig()['actions'][$this->Controller->request->params['action']]['rate_limit_limit'] : $this->getConfig()['rate_limit_limit'];
        
        $rateLimitRemaining = $rateLimitLimit - $httpRequestsDone;
        $rateLimitRemaining--;

        if ( $rateLimitRemaining < 0 ){
            $rateLimitRemaining = 0;
        }

        return $response
                ->withType('application/json')
                ->withHeader('X-Rate-Limit-Limit', $rateLimitLimit )
                ->withHeader('X-Rate-Limit-Remaining', $rateLimitRemaining);
                //->withHeader('X-Rate-Limit-Reset', $rateLimitReset);
    }

    protected function getResponseTooManyRequests( $response ){
        return $response
                ->withType('application/json')
                ->withStatus(429);
    }

    public function validateRules(){
        if ( !$this->validateRateLimit() ){
            return false;
        }
        
        if ( !$this->validateTimeWindowLastRecord() ){
            return false;
        }

        return true;
    }

    /**
     * Valida que no se haya superado el máximo de peticiones establecido
     *
     * @return void
     */
    public function validateRateLimit(){
        $rateLimitLimit = $this->getConfig()['rate_limit_limit'];

        if ( $this->isActionConfigured($this->Controller->request->params['action']) ){
            if ( isset($this->getConfig()['actions'][$this->Controller->request->params['action']]['rate_limit_limit']) ){
                $rateLimitLimit = $this->getConfig()['actions'][$this->Controller->request->params['action']]['rate_limit_limit'];
            }
        }

        $rateLimitLimit--;

        $countRows = $this->getCountRateLimit();
        
        return $countRows <= $rateLimitLimit;
    }

    /**
     * Valida que la diferencia entre AHORA y la fecha de modificación de algún registro NO sea inferior al rate_limit_window_last_record
     *
     * @return void
     */
    public function validateTimeWindowLastRecord(){
        $countRows = $this->getCountRateLimitWindowLastRecord();
        return $countRows == 0 ;
    }

    protected function getCountRateLimit(){
        $rateLimitLimit = $this->getConfig()['rate_limit_limit'];
        $rateLimitWindow = $this->getConfig()['rate_limit_window'];
        
        $conditions = [
            $this->HttpRequestsModel->alias().'.plugin' => $this->Controller->request->params['plugin'],
            $this->HttpRequestsModel->alias().'.controller' => $this->Controller->request->params['controller'],
            $this->HttpRequestsModel->alias().'.ip' => $this->Controller->request->clientIp(),
        ];

        $configuredActions = $this->getConfiguredActions();

        if ( !empty($configuredActions) && in_array($this->Controller->request->params['action'], $configuredActions) ){
            $conditions[$this->HttpRequestsModel->alias().'.action'] = $this->Controller->request->params['action'];

            if ( isset($this->getConfig()['actions'][$this->Controller->request->params['action']]['rate_limit_limit']) ){
                $rateLimitLimit = $this->getConfig()['actions'][$this->Controller->request->params['action']]['rate_limit_limit'];
            }
        }

        if ( isset($this->getConfig()['actions'][$this->Controller->request->params['action']]['rate_limit_window']) ){
            $rateLimitWindow = $this->getConfig()['actions'][$this->Controller->request->params['action']]['rate_limit_window'];
        }

        $startDate = date("Y-m-d H:i:s" , strtotime(date("Y-m-d H:i:s") . " -" . $rateLimitWindow . " seconds"));

        $query = $this->HttpRequestsModel->find('all')
        ->where($conditions)
        ->andWhere(function ($exp, $q) use ($startDate) {
            return $exp->between('modified', $startDate, $q->func()->now());
        });

        return $query->count();
    }

    protected function getCountRateLimitWindowLastRecord(){
        $rateLimitWindowLastRecord = $this->getConfig()['rate_limit_window_last_record'];
        
        $conditions = [
            $this->HttpRequestsModel->alias().'.plugin' => $this->Controller->request->params['plugin'],
            $this->HttpRequestsModel->alias().'.controller' => $this->Controller->request->params['controller'],
            $this->HttpRequestsModel->alias().'.ip' => $this->Controller->request->clientIp(),
        ];

        if ( $this->isActionConfigured($this->Controller->request->params['action']) ){
            $conditions[$this->HttpRequestsModel->alias().'.action'] = $this->Controller->request->params['action'];
        }

        if ( isset($this->getConfig()['actions'][$this->Controller->request->params['action']]['rate_limit_window_last_record']) ){
            $rateLimitWindowLastRecord = $this->getConfig()['actions'][$this->Controller->request->params['action']]['rate_limit_window_last_record'];
        }

        $startDate = date("Y-m-d H:i:s" , strtotime(date("Y-m-d H:i:s") . " -" . $rateLimitWindowLastRecord . " seconds"));

        $query = $this->HttpRequestsModel->find('all')
        ->where($conditions)
        ->andWhere(function ($exp, $q) use ($startDate) {
            return $exp->between('modified', $startDate, $q->func()->now());
        });

        return $query->count();
    }

    private function getConfiguredActions(){
        return $this->getConfig()['actions'];
    }

    private function isActionConfigured($action = null){
        if (!$action){
            return false;
        }

        $configuredActions = $this->getConfiguredActions();
        
        if ( !empty($configuredActions) ){
            return in_array($action, array_keys($configuredActions));
        }

        return false;
    }
}