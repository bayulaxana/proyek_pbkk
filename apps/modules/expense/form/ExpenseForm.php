<?php

namespace ServiceLaundry\Expense\Forms\Web;

use ServiceLaundry\Common\Forms\BaseForm;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\File;

use Phalcon\Tag;

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Digit;

class ExpenseForm extends BaseForm
{
    public function initialize()
    {
        $expense_note = new TextArea('expense_note', [
            'placeholder'   => 'Masukkan Catatan Pengeluaran',
            'class'         => 'form-control'
        ]);
        $expense_note->setLabel('Catatan Pengeluaran');
        $expense_note->addValidator(new PresenceOf(['message'=>'Catatan Pengeluaran belum diisi']));
    
        $expense_total = new Text('expense_total', [
            'placeholder'   => 'Masukkan Total Pengeluaran',
            'class'         => 'form-control'
        ]);
        $expense_total->setLabel('Total Pengeluaran');
        $expense_total->addValidator(new PresenceOf(['message'=>'Total Pengeluaran belum diisi']));
        $expense_total->addValidator(new Digit(['message'=>'Total Pengeluaran hanya terdiri dari angka']));
    
        $invoice = new File('invoice', [
            'placeholder'   => 'Cari File',
            'class'         => 'form-control'
        ]);
        $invoice->setLabel('Tambah Nota Pengeluaran');
        $invoice->addValidator(new PresenceOf(['message'=>'Nota Pengeluaran belum ditambahkan']));
    
        $submit = new Submit ('Simpan',
        [
            'name' => 'Simpan',
            "class" => "btn btn-success"
        ]);
    
        $this->add($expense_note);
        $this->add($expense_total);
        $this->add($invoice);
        $this->add($submit);
    }
}

