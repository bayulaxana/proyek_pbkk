<?php

namespace ServiceLaundry\Order\Controllers\Web;

use ServiceLaundry\Common\Controllers\SecureController;
use ServiceLaundry\Order\Models\Web\Item;
use ServiceLaundry\Dashboard\Models\Web\Users;
use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;
use Phalcon\Di;
use Phalcon\Mvc\Model\Manager;

class ItemController extends SecureController
{
    public function indexAction()
    {
        /*
        *  Data for Items by User
        */
        $user_id = $this->session->get('auth')['id'];
        $items = Item::find("user_id = '$user_id'");
        
        $this->view->items = $items;
        $this->view->pick('views/item/index');
    }

    public function updateAction()
    {

    }

    public function deleteAction()
    {
        
    }
}