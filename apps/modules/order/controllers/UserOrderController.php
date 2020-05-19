<?php

namespace ServiceLaundry\Order\Controllers\Web;

use ServiceLaundry\Common\Controllers\SecureController;
use ServiceLaundry\Dasboard\Models\Web\Users;
use ServiceLaundry\Order\Models\Web\Service;
use ServiceLaundry\Order\Models\Web\Item;
use ServiceLaundry\Order\Models\Web\OrderItem;
use ServiceLaundry\Order\Models\Web\Orders;
use Phalcon\Http\Response;

class UserOrderController extends SecureController
{
    public function initialize()
    {
        $this->memberExecutionRouter();
        $this->setFlashSessionDesign();
    }

    public function createOrderAction()
    {
        $service             = Service::find();
        $this->view->service = $service;
        $this->view->pick('views/order/users');
    }

    public function storeOrderAction()
    {
        $service_id           = $this->request->getPost('pilihan');
        $user_id              = $this->session->get('auth')['id'];
        $order_total          = $this->request->getPost('order_total');
        $order_date           = date('Y-m-d');
        $finish_date          = date('Y-m-d', strtotime(' +4 days'));
        $order_status         = 'Unfinished';
        $items_photo          = $this->request->getUploadedFiles();
        $items_notes_array    = $this->request->getPost('item_notes');
        $items_type_array     = $this->request->getPost('item_types');

        $order      = new Orders();
        $order->construct($service_id,$user_id,$order_total,$order_date,$finish_date,$order_status);

        if($this->request->hasFiles() == true)
        {
            if($order->save())
            {
                $this->flashSession->success('Pesanan telah dikirim. Terima kasih');
            }
            else
            {
                $this->flashSession->error('Maaf pesanan tidak terkirim. Mohon coba kembali');
                $this->response->redirect('/order/users');
            }
    
            for($i=0; $i<count($items_notes_array) ; $i++)
            {
                $item       = new Item();
                $item->construct($user_id,$items_notes_array[$i],$items_type_array[$i],'temp.jpg');
                $item->save();

                $filename_toDB  = "img_item/" . $item->getId() . '.' .$items_photo[$i]->getExtension();
                $save_file      = BASE_PATH . '/public/' . $filename_toDB;
                $items_photo[$i]->moveTo($save_file);
                $item->construct($user_id,$items_notes_array[$i],$items_type_array[$i],$filename_toDB);
                $item->update();
    
                $order_item = new OrderItem();
                $order_item->construct($item->getId(),$order->getId());
                $order_item->save();
            }
        }
        $this->response->redirect('/order/users');
    }

    public function listOrderAction()
    {
        $user_id        = $this->session->get('auth')['id'];
        $array_data     = array();
        (!isset($_GET['page'])) ? $currentPage = 1 : $currentPage = (int) $this->request->getQuery('page');
        $number_page    = 3;
        $offset         = ($currentPage-1) * $number_page;
        $total_row      = count(Orders::find());
        $total_page     = ceil($total_row/$number_page);

        $queries = $this
        ->modelsManager
        ->createQuery("SELECT service_name, Orders.order_id AS order_id, order_total, order_date, finish_date, order_status
                        FROM ServiceLaundry\Order\Models\Web\Service AS Services, ServiceLaundry\Order\Models\Web\Orders AS Orders 
                        WHERE Services.service_id = Orders.service_id AND Orders.user_id =".$user_id);
        $temps      = $queries->execute();
        $sql        = $temps->toArray();

        $detail_item    = array();
        $i = 0;
        foreach( $sql as $idx)
        {
            $query = $this
                    ->modelsManager
                    ->createQuery('SELECT comment_id, comment_content, comment_status FROM ServiceLaundry\Order\Models\Web\Comment AS Comment
                                    WHERE Comment.order_id = ' .$idx['order_id']);
            $temp             = $query->execute();
            $detail_item[$i]  = $temp->toArray();   
            $i++;
        }

        $this->view->page            = $sql;
        $this->view->detail_item     = $detail_item;
        $this->view->pick('views/order/listorder');
    }
}