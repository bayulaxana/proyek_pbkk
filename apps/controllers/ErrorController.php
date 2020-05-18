<?php

namespace ServiceLaundry\Common\Controllers;

use Phalcon\Mvc\Controller;

class ErrorController extends Controller
{
    public function error404Action()
    {
       $this->view->setViewsDir(APP_PATH . '/views/');
       $this->view->setMainView('error404');
       $this->view->setLayout('error404');
    }
}