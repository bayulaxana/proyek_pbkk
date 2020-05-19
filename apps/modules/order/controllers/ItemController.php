<?php

namespace ServiceLaundry\Order\Controllers\Web;

use ServiceLaundry\Common\Controllers\SecureController;
use ServiceLaundry\Order\Models\Web\Item;
use ServiceLaundry\Order\Forms\Web\ItemForm;
use ServiceLaundry\Order\Models\Web\OrderItem;
use ServiceLaundry\Dashboard\Models\Web\Users;
use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;
use Phalcon\Di;
use Phalcon\Mvc\Model\Manager;

class ItemController extends SecureController
{
    public function initialize()
    {
        $this->memberExecutionRouter();
        $this->setFlashSessionDesign();
    }

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
        if(!$this->request->isPost())
        {
            $this->response->redirect('item');
        }

        $form = new ItemForm();
        $flag = 0;
        if(!$form->isValid($this->request->getPost()))
        {
            foreach ($form->getMessages() as $msg)
            {
                if($msg->getMessage()!=null && $msg->getField()!='item_photo')
                {
                    $flag = 1;
                    $this->flashSession->error($msg->getMessage());
                }
            }
        }

        if($this->request->hasFiles() == true && !$flag)
        {
            $item_id = $this->request->getPost('item_id');
            $item    = Item::findFirst("item_id='$item_id'");
            if($item==null)
            {
                $this->flashSession->error('Terjadi error saat pencarian data. Mohon coba ulang kembali');
            }

            if($item != null && $this->request->hasFiles() == true)
            {
                $old_file      = BASE_PATH . '/public/' .$item->getItemPhoto();
                $user_id       = $this->session->get('auth')['id'];
                $item_details  = $this->request->getPost('item_details');
                $item_type     = $this->request->getPost('item_type');

                if(!unlink($old_file))
                {
                    $this->flashSession->error('File lama tidak dapat dihapus');
                }
                else
                {
                    foreach($this->request->getUploadedFiles() as $file)
                    {
                        $filename_toDB  = 'img_item/' .$item_id. '.' .$file->getExtension();
                        $save_file      = BASE_PATH . '/public/' .$filename_toDB;
                        $file->moveTo($save_file);
                        $item->construct($user_id,$item_details,$item_type,$filename_toDB);
                        $item->update();
                    }
                    $this->flashSession->success('Data Item berhasil diperbarui');
                }
            }    
        }
        $this->response->redirect('item');
    }

    public function deleteAction()
    {
        if(!$this->request->isPost())
        {
            return $this->response->redirect('item');
        }
        $item_id = $this->request->getPost('item_id');
        if($item_id != null)
        {
            $item       = Item::findFirst("item_id='$item_id'");
            $order_item = OrderItem::find("item_id='$item_id'");
            if($item != null)
            {
                $old_file = BASE_PATH . '/public/' .$item->getItemPhoto();
                if($item->delete())
                {
                    unlink($old_file);
                    $phql = "DELETE FROM ServiceLaundry\Order\Models\Web\OrderItem WHERE item_id='$item_id'";
                    $records  = $this->modelsManager->executeQuery($phql);
                    $this->flashSession->success('Data item berhasil dihapus');
                }
                else
                {
                    $this->flashSession->error('Data item tidak berhasil dihapus. Mohon coba ulang kembali');
                }
            }
            else
            {
                $this->flashSession->error('Data item tidak dapat ditemukan. Mohon coba ulang kembali');
            }
        }
        return $this->response->redirect('item');
    }
}