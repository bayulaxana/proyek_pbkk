<?php

namespace ServiceLaundry\Expense\Controllers\Web;

use ServiceLaundry\Common\Controllers\SecureController;
use ServiceLaundry\Expense\Forms\Web\ExpenseForm;
use ServiceLaundry\Expense\Models\Web\Expense;
use Phalcon\Mvc\Controller;
use Phalcon\Http\Response; 

class ExpenseController extends SecureController
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
        $total_row      = count(Expense::find());
        $total_page     = ceil($total_row/$number_page);

        $sql            = Expense::find([
                            'limit'     => $number_page,
                            'offset'    => $offset,
                        ]);
        $this->view->page           = $sql;
        $this->view->page_number    = $currentPage;
        $this->view->page_last      = $total_page;
        $this->view->offset         = $offset;
        $this->view->flashSession   = $this->flashSession;
        $this->view->form = new ExpenseForm();
        $this->view->pick('views/index');
    }

    public function storeExpenseAction()
    {
        if(!$this->request->isPost())
        {
            $this->response->redirect();
        }

        $form = new ExpenseForm();
        $flag = 0;
        if(!$form->isValid($this->request->getPost()))
        {
            foreach ($form->getMessages() as $msg)
            {
                if($msg->getMessage()!=null && $msg->getField()!='invoice')
                {
                    $flag = 1;
                    $this->flashSession->error($msg->getMessage());
                }
            }
        }

        if($this->request->hasFiles() == true && !$flag)
        {
            $admin_id         = $this->session->has('auth')['id'];
            $expense_note     = $this->request->getPost('expense_note');
            $expense_total    = $this->request->getPost('expense_total');
            $invoice          = "temp.jpg";

            $expense = new Expense();
            $expense->construct($admin_id,$expense_note,$expense_total,$invoice);

            if($expense->save())
            {
                foreach($this->request->getUploadedFiles() as $file)
                {
                    $filename_toDB  = "img_invoice/" . $expense->getId() . '.' .$file->getExtension();
                    $save_file      = BASE_PATH . '/public/' . $filename_toDB;
                    $file->moveTo($save_file);
                    $expense->construct($admin_id,$expense_note,$expense_total,$filename_toDB);
                    $expense->update();
                }
                $this->flashSession->success('Data Pengeluaran baru berhasil ditambahkan');
                $this->view->form = new ExpenseForm();
            }
            else
            {
                $this->flashSession->error('Terjadi kesalahan saat menambahkan data. Mohon, coba ulang kembali');
            }
            return $this->response->redirect('expense');
        }
    }

    public function updateExpenseAction()
    {
        if(!$this->request->isPost())
        {
            $this->response->redirect('expense');
        }

        $form = new ExpenseForm();
        if(!$form->isValid($this->request->getPost()))
        {
            foreach ($form->getMessages() as $msg)
            {
                if($msg->getMessage()!=null && $msg->getField()!='invoice')
                {
                    $flag = 1;
                    $this->flashSession->error($msg->getMessage());
                }
            }
        }

        if($this->request->hasFiles() == true && !$flag)
        {
            $expense_id = $this->request->getPost('expense_id');
            $expense    = Expense::findFirst("expense_id='$expense_id'");
            if($expense==null)
            {
                $this->flashSession->error('Terjadi error saat pencarian data. Mohon coba ulang kembali');
            }

            if($expense != null && $this->request->hasFiles() == true)
            {
                $old_file       = BASE_PATH . '/public/' .$expense->getInvoice();
                $admin_id       = $this->session->has('auth')['id'];
                $expense_note   = $this->request->getPost('expense_note');
                $expense_total  = $this->request->getPost('expense_total');
                $invoice        = $expense->getInvoice();

                if(!unlink($old_file))
                {
                    $this->flashSession->error('File lama tidak dapat dihapus');
                }
                else
                {
                    foreach($this->request->getUploadedFiles() as $file)
                    {
                        $filename_toDB  = 'img_invoice/' .$expense_id. '.' .$file->getExtension();
                        $save_file      = BASE_PATH . '/public/' .$filename_toDB;
                        $file->moveTo($save_file);
                        $expense->construct($admin_id,$expense_note,$expense_total,$filename_toDB);
                        $expense->update();
                    }
                    $this->flashSession->success('Data Pengeluaran berhasil diperbarui');
                }
            }    
        }
        $this->response->redirect('expense');
    }

    public function deleteExpenseAction()
    {
        if(!$this->request->isPost())
        {
            return $this->response->redirect('expense');
        }

        $expense_ids     = $this->request->getPost('expense_id');
        $expense_array  = explode(",",$expense_ids);

        foreach($expense_array as $expense_id)
        { 
            $expense = Expense::findFirst("expense_id='$expense_id'");
            if($expense != null)
            {
                $old_file   = BASE_PATH . '/public/' .$expense->getInvoice();
                if(!unlink($old_file))
                {
                    $this->flashSession->error('File tidak dapat ditemukan');
                }
                else
                {
                    $expense->delete();
                    $this->flashSession->success('Data Pengeluaran berhasil dihapus');
                }
            }
        }
       return $this->response->redirect('expense');
    }
}