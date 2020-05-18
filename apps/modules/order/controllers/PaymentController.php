<?php

namespace ServiceLaundry\Order\Controllers\Web;

use ServiceLaundry\Common\Controllers\SecureController;
use ServiceLaundry\Order\Models\Web\Payment;
use ServiceLaundry\Order\Forms\Web\PaymentForm;
use ServiceLaundry\Order\Models\Web\Orders;
use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;
use Phalcon\Di;

class PaymentController extends SecureController
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
        $total_row      = count(Payment::find());
        $total_page     = ceil($total_row/$number_page);

        $queries = $this
        ->modelsManager
        ->createQuery("SELECT name, Payment.order_id, Payment.payment_id, Payment.order_id, Payment.admin_id, Payment.payment_status, Payment.payment_time
                        FROM ServiceLaundry\Order\Models\Web\Payment AS Payment, ServiceLaundry\Order\Models\Web\Orders AS Orders, ServiceLaundry\Dashboard\Models\Web\Users AS Users
                        WHERE Orders.order_id = Payment.order_id AND Users.user_id = Orders.user_id
                        LIMIT ".$offset.",".$number_page);
                        
        $temps      = $queries->execute();
        $sql        = $temps->toArray();

        $this->view->page           = $sql;
        $this->view->page_number    = $currentPage;
        $this->view->page_last      = $total_page;
        $this->view->offset         = $offset;
        $this->view->form           = new PaymentForm();
        $this->view->pick('views/payment/index');
    }

    public function storePaymentAction()
    {
        if(!$this->request->isPost())
        {
            return $this->response->redirect('payment');
        }

        $form = new PaymentForm();
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

        $admin_id       = $this->session->get('auth')['id'];
        $order_id       = $this->request->getPost('order_id');
        $payment_status = $this->request->getPost('payment_status');
        $payment_time   = date('Y-m-d');

        $payment = new Payment();
        $payment->construct($order_id,$admin_id,$payment_status,$payment_time);

        if(!$flag)
        {
            if($payment->save())
            {
                $this->flashSession->success('Data Pembayaran berhasil ditambahkan');
                if($payment_status == 'Lunas')
                {
                    $order = Orders::findFirst(['conditions'=>'order_id='.$order_id]);
                    $order->construct($order->getServiceId(),$order->getUserId(),$order->getOrderTotal(),$order->getOrderDate(),$order->getFinishDate(),'Finished');
                    $order->update();
                }
            }
            else
            {
                $this->flashSession->error('Terjadi kesalahan saat menambahkan data. Mohon, coba ulang kembali');
            }
        }
        return $this->response->redirect('payment');
    }

    public function updatePaymentAction()
    {
        if(!$this->request->isPost())
        {
            $this->response->redirect('payment');
        }

        $form = new PaymentForm();
        $flag = 0;
        if(!$form->isValid($this->request->getPost()))
        {
            foreach ($form->getMessages() as $msg)
            {
                if($msg->getMessage()!=null && $msg->getField()!='order_id')
                {
                    $flag = 1;
                    $this->flashSession->error($msg->getMessage());
                }
            }
        }

        $payment_id   = $this->request->getPost('payment_id');
        $payment      = Payment::findFirst("payment_id='$payment_id'");

        if($payment != null && !$flag)
        {
            $admin_id           = $this->session->get('auth')['id'];
            $order_id           = $payment->getOrderId();
            $payment_status     = $this->request->getPost('payment_status');
            $payment_time       = date('Y-m-d');

            $payment->construct($order_id,$admin_id,$payment_status,$payment_time);
            if($payment->update())
            {
                $this->flashSession->success('Data Pembayaran berhasil diubah');
                $payment_status == 'Lunas' ? $status = 'Finished' : $status = 'Unfinished';
                $order = Orders::findFirst(['conditions'=>'order_id='.$order_id]);
                $order->construct($order->getServiceId(),$order->getUserId(),$order->getOrderTotal(),$order->getOrderDate(),$order->getFinishDate(),$status);
                $order->update();
            }
            else
            {
                $this->flashSession->error('Data Pembayaran tidak berhasil diubah. Mohon coba ulang kembali');
            }
        }
        else
        {
            $this->flashSession->error('Data yang dipilih tidak ada. Mohon coba ulang kemabali');
        }
        return $this->response->redirect('payment');
    }

    public function deletePaymentAction()
    {
        if(!$this->request->isPost())
        {
            return $this->response->redirect('payment');
        }

        $payment_id_string     = $this->request->getPost('payment_id');
        $payment_id_array      = explode(",", $payment_id_string);

        foreach($payment_id_array as $payment_id){
            if($payment_id != null)
            {
                $payment     = Payment::findFirst("payment_id='$payment_id'");
                if($payment != null)
                {
                    $order = Orders::findFirst(['conditions'=>'order_id='.$payment->getOrderId()]);
                    $order->construct($order->getServiceId(),$order->getUserId(),$order->getOrderTotal(),$order->getOrderDate(),$order->getFinishDate(),'Unfinished');
                    if($payment->delete())
                    {
                        $this->flashSession->success('Data Pembayaran berhasil dihapus');
                        $order->update();
                    }
                    else
                    {
                        $this->flashSession->error('Data Pembayaran tidak berhasil dihapus. Mohon coba ulang kembali');
                    }
                }
                else
                {
                    $this->flashSession->error('Data Pembayaran tidak dapat ditemukan. Mohon coba ulang kembali');
                }
            }
        }
        return $this->response->redirect('payment');
    }
}