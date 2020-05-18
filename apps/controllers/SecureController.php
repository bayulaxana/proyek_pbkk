<?php

namespace ServiceLaundry\Common\Controllers;

use Phalcon\Mvc\Controller;

class SecureController extends Controller
{
    public function adminExecutionRouter()
    {
        if($this->session->get('auth')['role'] != 1)
        {
            return $this->response->redirect("home");
        }
    }

    public function memberExecutionRouter()
    {
        if($this->session->get('auth')['role'] != 0)
        {
            return $this->response->redirect("");
        }
    }

    /*
    * Styling for flasSession
    */
    public function setFlashSessionDesign()
    {
        $this->flashSession->setCssClasses([        
            'error'   => 'alert alert-danger',
            'success' => 'alert alert-success', 
            'notice'  => 'alert alert-info',
            'warning' => 'alert alert-warning'
        ]);
    }

    protected function back()
    {
        return $this->response->redirect($_SERVER['HTTP_REFERER']);
    }
}