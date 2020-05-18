<?php

namespace ServiceLaundry\Order\Controllers\Web;

use ServiceLaundry\Common\Controllers\SecureController;
use ServiceLaundry\Order\Models\Web\Service;
use ServiceLaundry\Order\Forms\Web\ServiceForm;
use Phalcon\Http\Response;
use Phalcon\Di;

class ServiceController extends SecureController
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
        $price_row      = count(Service::find());
        $price_page     = ceil($price_row/$number_page);

        $sql            = Service::find([
                            'limit'     => $number_page,
                            'offset'    => $offset,
                        ]);
        
        $this->view->page           = $sql;
        $this->view->page_number    = $currentPage;
        $this->view->page_last      = $price_page;
        $this->view->offset         = $offset;
        $this->view->form           = new ServiceForm();
        $this->view->pick('views/service/index');
    }

    public function storeServiceAction()
    {
        if(!$this->request->isPost())
        {
            $this->response->redirect();
        }

        $form = new ServiceForm();
        $flag = 0;
        if(!$form->isValid($this->request->getPost()))
        {
            foreach ($form->getMessages() as $msg)
            {
                if($msg->getMessage()!=null && $msg->getField()!='service_photo')
                {
                    $flag = 1;
                    $this->flashSession->error($msg->getMessage());
                }
            }
        }

        if($this->request->hasFiles() == true && !$flag)
        {
            $service_name     = $this->request->getPost('service_name');
            $service_price    = $this->request->getPost('service_price');
            $photo            = "temp.jpg";

            $service = new Service();
            $service->construct($service_name,$photo,$service_price);
            if($service->save())
            {
                foreach($this->request->getUploadedFiles() as $file)
                {
                    $filename_toDB  = "img_service/" . $service->getId() . '.' .$file->getExtension();
                    $save_file      = BASE_PATH . '/public/' . $filename_toDB;
                    $file->moveTo($save_file);
                    $service->construct($service_name,$filename_toDB,$service_price);
                    $service->update();
                }
                $this->flashSession->success('Data Service baru berhasil ditambahkan');
                $this->view->form = new ServiceForm();
            }
            else
            {
                $this->flashSession->error('Terjadi kesalahan saat menambahkan data. Mohon, coba ulang kembali');
            }
        }
        return $this->response->redirect('service');
    }

    public function updateServiceAction()
    {
        if(!$this->request->isPost())
        {
            $this->response->redirect('service');
        }

        $form = new ServiceForm();
        $flag = 0;
        if(!$form->isValid($this->request->getPost()))
        {
            foreach ($form->getMessages() as $msg)
            {
                if($msg->getMessage()!=null && $msg->getField()!='service_photo')
                {
                    $flag = 1;
                    $this->flashSession->error($msg->getMessage());
                }
            }
        }

        if($this->request->hasFiles() == true && !$flag)
        {
            $service_id = $this->request->getPost('service_id');
            $service    = Service::findFirst("service_id='$service_id'");
            if($service==null)
            {
                $this->flashSession->error('Terjadi error saat pencarian data. Mohon coba ulang kembali');
            }

            if($service != null && $this->request->hasFiles() == true)
            {
                $old_file         = BASE_PATH . '/public/' .$service->getServicePhoto();
                $service_name     = $this->request->getPost('service_name');
                $service_price    = $this->request->getPost('service_price');
                $service_photo    = $service->getServicePhoto();

                if(!unlink($old_file))
                {
                    $this->flashSession->error('File lama tidak dapat dihapus');
                }
                else
                {
                    foreach($this->request->getUploadedFiles() as $file)
                    {
                        $filename_toDB  = 'img_service/' .$service_id. '.' .$file->getExtension();
                        $save_file      = BASE_PATH . '/public/' .$filename_toDB;
                        $file->moveTo($save_file);
                        $service->construct($service_name,$filename_toDB,$service_price);
                        $service->update();
                    }
                    $this->flashSession->success('Data Service berhasil diperbarui');
                }
            }    
        }
        $this->response->redirect('service');
    }

    public function deleteServiceAction()
    {
        if(!$this->request->isPost())
        {
            return $this->response->redirect('service');
        }
        $service_id_string     = $this->request->getPost('service_id');
        $service_id_array      = explode(",", $service_id_string);

        foreach($service_id_array as $service_id){
            if($service_id != null)
            {
                $service     = Service::findFirst("service_id='$service_id'");
                if($service != null)
                {
                    $old_file = BASE_PATH . '/public/' .$service->getServicePhoto();
                    if($service->delete())
                    {
                        unlink($old_file);
                        $this->flashSession->success('Data Service berhasil dihapus');
                    }
                    else
                    {
                        $this->flashSession->error('Data Service tidak berhasil dihapus. Mohon coba ulang kembali');
                    }
                }
                else
                {
                    $this->flashSession->error('Data Service tidak dapat ditemukan. Mohon coba ulang kembali');
                }
            }
        }
        return $this->response->redirect('service');
    }
}