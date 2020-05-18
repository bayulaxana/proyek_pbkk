<?php

namespace ServiceLaundry\Expense\Models\Web;

use Phalcon\Mvc\Model;

class Expense extends Model
{
    private $expense_id;
    private $admin_id;
    private $expense_note;
    private $expense_total;
    private $invoice;

    public function initialize()
    {
        $this->setSource('Expense');
    }

    public function construct($admin_id,$expense_note,$expense_total,$invoice)
    {
        $this->admin_id         = $admin_id;
        $this->expense_note     = $expense_note;
        $this->expense_total    = $expense_total;
        $this->invoice          = $invoice;
    }

    public function getId()
    {
        return $this->expense_id;
    }

    public function getAdminId()
    {
        return $this->admin_id;
    }

    public function getExpenseNote()
    {
        return $this->expense_note;
    }

    public function getExpenseTotal()
    {
        return $this->expense_total;
    }

    public function getInvoice()
    {
        return $this->invoice;
    }
}