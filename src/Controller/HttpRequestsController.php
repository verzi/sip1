<?php

namespace App\Controller;

class HttpRequestsController extends AppController
{

    public function index()
    {
        $httpRequests = $this->HttpRequests->find('all');
        $this->set(compact('httpRequests'));
    }
}