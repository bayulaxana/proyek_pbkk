<?php
namespace ServiceLaundry\Order\Controllers\Web;

use ServiceLaundry\Common\Controllers\SecureController;
use ServiceLaundry\Order\Forms\Web\CommentForm;
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
            return $this->response->redirect('listorder');
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

        $user_id                = $this->session->get('auth')['id'];
        $comment_content        = $this->request->getPost('comment_content');
        $comment_status         = $this->request->getPost('comment_status');
        $comment_date           = date('Y-m-d');
        $order_id               = $this->request->getPost('order_id');

        $comment = new Comment();
        $comment->construct($user_id,$comment_content,$comment_status,$comment_date,$order_id);

        if(!$flag)
        {
            if($comment->save())
            {
                $this->flashSession->success('Data Komentar berhasil ditambahkan');
            }
            else
            {
                $this->flashSession->error('Terjadi kesalahan saat menambahkan data. Mohon, coba ulang kembali');
            }
        }
        return $this->response->redirect('listorder');
    }

    public function updateAction()
    {
        if(!$this->request->isPost())
        {
            $this->response->redirect('listorder');
        }

        $form = new CommentForm();
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

        $comment_id   = $this->request->getPost('comment_id');
        $comment      = Comment::findFirst("comment_id='$comment_id'");

        if($comment != null && !$flag)
        {
            $user_id            = $this->session->get('auth')['id'];
            $comment_content    = $this->request->getPost('comment_content');
            $comment_status     = $this->request->getPost('comment_status');
            $comment_date       = date('Y-m-d');
            $order_id           = $this->request->getPost('order_id');
    
            $comment->construct($user_id,$comment_content,$comment_status,$comment_date,$order_id);
            if($comment->update())
            {
                $this->flashSession->success('Data Pembayaran berhasil diubah');
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
        return $this->response->redirect('listorder');
    }

    public function deleteAction()
    {
        if(!$this->request->isPost())
        {
            return $this->response->redirect('listorder');
        }
        $comment_id = $this->request->getPost('comment_id');
        if($comment_id != null)
        {
            $comment       = Comment::findFirst("comment_id='$comment_id'");
            if($comment != null)
            {
                if($comment->delete())
                {
                    $this->flashSession->success('Data komentar berhasil dihapus');
                }
                else
                {
                    $this->flashSession->error('Data komentar tidak berhasil dihapus. Mohon coba ulang kembali');
                }
            }
        }
        return $this->response->redirect('listorder');
    }
}