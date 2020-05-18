<?php

namespace ServiceLaundry\Order\Controllers\Web;

use ServiceLaundry\Common\Controllers\SecureController;
use ServiceLaundry\Order\Forms\Web\OrderForm;
use ServiceLaundry\Order\Models\Web\Orders;
use ServiceLaundry\Order\Models\Web\Item;
use ServiceLaundry\Order\Models\Web\OrderItem;
use ServiceLaundry\Order\Models\Web\Service;
use ServiceLaundry\Dashboard\Models\Web\Users;
use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;
use Phalcon\Di;
use Phalcon\Mvc\Model\Manager;

class OrderController extends SecureController
{
    public function initialize()
    {
        $this->adminExecutionRouter();
        $this->setFlashSessionDesign();
    }
    
    public function indexAction()
    {
        /*
        * Manual pagination
        */ 
        $array_data     = array();
        (!isset($_GET['page'])) ? $currentPage = 1 : $currentPage = (int) $this->request->getQuery('page');
        $number_page    = 3;
        $offset         = ($currentPage-1) * $number_page;
        $total_row      = count(Orders::find());
        $total_page     = ceil($total_row/$number_page);

        $queries = $this
        ->modelsManager
        ->createQuery("SELECT name, service_name, Orders.order_id, Orders.service_id, Orders.user_id, Orders.order_total, Orders.order_date, Orders.finish_date, Orders.order_status 
                        FROM ServiceLaundry\Order\Models\Web\Service AS Services, ServiceLaundry\Order\Models\Web\Orders AS Orders, ServiceLaundry\Dashboard\Models\Web\Users AS Users 
                        WHERE Services.service_id = Orders.service_id AND Users.user_id = Orders.user_id
                        LIMIT ".$offset.",".$number_page);

        $temps      = $queries->execute();
        $sql        = $temps->toArray();
        
        /*
        * Get all items for every orders
        */
        $detail_item    = array();
        $i = 0;
        foreach( $sql as $idx)
        {
            $query = $this
                    ->modelsManager
                    ->createQuery('SELECT item_type, item_details FROM ServiceLaundry\Order\Models\Web\Item AS Item , ServiceLaundry\Order\Models\Web\OrderItem AS OrderItem
                                    WHERE Item.item_id = OrderItem.item_id 
                                    AND OrderItem.order_id =' .$idx['Orders_order_id']);
            $temp             = $query->execute();
            $detail_item[$i]  = $temp->toArray();   
            $i++;
        }

        $this->view->page           = $sql;
        $this->view->page_number    = $currentPage;
        $this->view->page_last      = $total_page;
        $this->view->offset         = $offset;
        $this->view->detail_item    = $detail_item;
        $this->view->pick('views/order/index');
    }

    public function updateOrderAction()
    {
        if(!$this->request->isPost())
        {
            $this->response->redirect('order');
        }

        $form = new OrderForm();
        $flag = 0;
        if(!$form->isValid($this->request->getPost()))
        {
            foreach ($form->getMessages() as $msg)
            {
                if($msg->getMessage()!=null)
                {
                    $flag = 1;
                    $this->flashSession->error($msg->getMessage());
                }
            }
        }

        $order_id   = $this->request->getPost('order_id');
        $order      = Orders::findFirst("order_id='$order_id'");
        if($order != null && !$flag)
        {
            $service_id         = $order->getServiceId();
            $user_id            = $order->getUserId();
            $order_total        = $order->getOrderTotal();
            $order_status       = $this->request->getPost('order_status');
            $order_date         = $order->getOrderDate();
            $finish_date        = $this->request->getPost('finish_date');

            $order->construct($service_id,$user_id,$order_total,$order_date,$finish_date,$order_status);
            if($order->update())
            {
                $this->flashSession->success('Data Pesanan berhasil diubah');
            }
            else
            {
                $this->flashSession->error('Data Pesanan tidak berhasil diubah. Mohon coba ulang kembali');
            }
        }
        else
        {
            $this->flashSession->error('Data yang dipilih tidak ada. Mohon coba ulang kemabali');
        }
        return $this->response->redirect('order');
    }
}