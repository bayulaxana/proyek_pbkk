<?php

namespace ServiceLaundry\Dashboard\Controllers\Web;

use ServiceLaundry\Common\Controllers\SecureController;
use ServiceLaundry\Dashboard\Forms\Web\UserForm;
use ServiceLaundry\Order\Models\Web\Orders;
use ServiceLaundry\Order\Models\Web\Service;
use ServiceLaundry\Dashboard\Models\Web\Users;
use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;

class IndexController extends SecureController
{
    public function initialize()
    {
        $this->adminExecutionRouter();
        $this->setFlashSessionDesign();
    }

    public function indexAction()
    {
        $unprocessed_order      = count(Orders::find("order_status = 'Unfinished'"));
        $completed_order        = count(Orders::find("order_status = 'Finished'"));
        $datas                  = Service::find(['limit' => 3]);
        /*
        *   Data for Chart
        */
        $query = $this
        ->modelsManager
        ->createQuery("SELECT Payment.payment_time AS dates , SUM(order_total) AS total FROM ServiceLaundry\Order\Models\Web\Orders AS Orders , ServiceLaundry\Order\Models\Web\Payment AS Payment 
                        WHERE Orders.order_id = Payment.order_id AND  Payment.payment_status='Lunas'
                        GROUP BY Payment.payment_time
                        ORDER BY Payment.payment_time DESC
                        LIMIT 5");
                        
        $temp   = $query->execute();
        $chart  = $temp->toArray();    
        /*
        * Income Today
        */
        $sql = $this
        ->modelsManager
        ->createQuery("SELECT SUM(order_total) AS total FROM ServiceLaundry\Order\Models\Web\Orders AS Orders , ServiceLaundry\Order\Models\Web\Payment AS Payment 
                        WHERE Orders.order_id = Payment.order_id AND  Payment.payment_status='Lunas' AND Payment.payment_time=CAST(GETDATE() AS DATE)");
        
        $temps  = $sql->execute();
        $income = $temps->toArray();

        $this->view->completed_order    = $completed_order;
        $this->view->unprocessed_order  = $unprocessed_order;
        $this->view->datas              = $datas;
        $this->view->chart              = $chart;
        $this->view->income             = $income[0]['total'] == null? 0 : $income[0]['total'];
        $this->view->form               = new UserForm();
        $this->view->pick('views/index');
    }

    public function storeAdminAction()
    {
        if(!$this->request->isPost())
        {
            $this->response->redirect();
        }

        $form = new UserForm();
        if($this->request->getPost('gender') == null)
        {
            $this->flashSession->error('Anda harus mengisi jenis kelamin');
            $this->response->redirect();
        }

        $username = $this->request->getPost('username');
        if(Users::findFirst("username='$username'"))
        {
            $this->flashSession->error('Username sudah digunakan');
            $this->response->redirect();
        }

        $flag = 0;
        if(!$form->isValid($this->request->getPost()))
        {
            foreach ($form->getMessages() as $msg)
            {
                if($msg->getMessage()!=null && $msg->getField()!='profile_img')
                {
                    $flag = 1;
                    $this->flashSession->error($msg->getMessage());
                }
            }
        }

        if($this->request->hasFiles() == true && !$flag)
        {
            $username       = $this->request->getPost('username');
            $password       = $this->security->hash($this->request->getPost('password'));
            $name           = $this->request->getPost('name');
            $gender         = $this->request->getPost('gender');
            $address        = $this->request->getPost('address');
            $register_date  = date('Y-m-d');
            $role           = 1;
            $phone          = $this->request->getPost('phone');
            $email          = $this->request->getPost('email');
            $profile_img    = "temp.jpg";

            $admin = new Users();
            $admin->construct($username,$password,$name,$gender,$address,$register_date,$role,$phone,$email,$profile_img);

            if($admin->save())
            {
                foreach($this->request->getUploadedFiles() as $file)
                {
                    $filename_toDB  = "img_profile/" . $admin->getId() . '.' .$file->getExtension();
                    $save_file      = BASE_PATH . '/public/' . $filename_toDB;
                    $file->moveTo($save_file);
                    $admin->construct($username,$password,$name,$gender,$address,$register_date,$role,$phone,$email,$filename_toDB);
                    $admin->update();
                }
                $this->flashSession->success('Admin baru berhasil ditambahkan');
                $this->view->form = new UserForm();
            }
            else
            {
                $this->flashSession->error('Terjadi kesalahan saat menambahkan data. Mohon, coba ulang kembali');
            }
        }
        return $this->response->redirect();
    }
}