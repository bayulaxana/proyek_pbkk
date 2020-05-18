<?php

namespace ServiceLaundry\Order\Forms\Web;

use ServiceLaundry\Common\Forms\BaseForm;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Date;

use Phalcon\Tag;

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;

class OrderForm extends BaseForm
{
    public function initialize()
    {
        $finish_date = new Date('finish_date', [
            'placeholder'   => 'Masukkan tanggal selesai order service',
            'class'         => 'form-control'
        ]);
        $finish_date->setLabel('Tanggal Selesai Service Order');
        $finish_date->addValidator(new PresenceOf(['message'=>'Tanggal Selesai Service Order belum diisi']));

        $order_status = new Text('order_status', [
            'placeholder'   => 'Masukkan Status Order Service',
            'class'         => 'form-control'
        ]);
        $order_status->setLabel('Status Order');
        $order_status->addValidator(new PresenceOf(['message'=>'Status Order Service belum diisi']));

        $submit = new Submit ('Simpan',
        [
            'name' => 'Simpan',
            "class" => "btn btn-success"
        ]);

        $this->add($finish_date);
        $this->add($order_status);
        $this->add($submit);
    }
}