<?php
namespace ServiceLaundry\Order\Controllers\Web;

use ServiceLaundry\Common\Controllers\SecureController;
use ServiceLaundry\Dasboard\Models\Web\Users;
use ServiceLaundry\Order\Models\Web\Service;
use ServiceLaundry\Order\Models\Web\Comment;
use ServiceLaundry\Order\Models\Web\Orders;
use Phalcon\Http\Response;

class CommentController extends SecureController
{
    public function initialize()
    {
        $this->memberExecutionRouter();
        $this->setFlashSessionDesign();
    }

    public function storeAction()
    {
        if(!$this->request->isPost())
        {
            return $this->response->redirect('order');
        }

        $form = new CommentForm();
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
        return $this->response->redirect('order');
    }

    public function updateAction()
    {

    }

    public function deleteAction()
    {
        if(!$this->request->isPost())
        {
            return $this->response->redirect('order');
        }
        $comment_id = $this->request->getPost('comment_id');
        if($comment_id != null)
        {
            $comment       = Comment::findFirst("comment_id='$comment_id'");
            if($comment != null)
            {
                if($comment->delete())
                {
                    $this->flashSession->success('Data comment berhasil dihapus');
                }
                else
                {
                    $this->flashSession->error('Data comment tidak berhasil dihapus. Mohon coba ulang kembali');
                }
            }
        }
        return $this->response->redirect('order');
    }
}