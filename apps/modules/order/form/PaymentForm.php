<?php

namespace ServiceLaundry\Order\Forms\Web;

use ServiceLaundry\Common\Forms\BaseForm;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\Submit;

use Phalcon\Tag;

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;

class PaymentForm extends BaseForm
{
    public function initialize()
    {
        $order_id           = new Text('order_id', [
            'placeholder'   => 'Masukkan Order Id',
            'class'         => 'form-control'
        ]);
        $order_id->setLabel('Order Id');
        $order_id->addValidator(new PresenceOf(['message'=>'Order Id belum diisi']));

        $payment_status     = new Text('payment_status', [
            'placeholder'   => 'Masukkan Status Pembayaran',
            'class'         => 'form-control'
        ]);
        $payment_status->setLabel('Status Pembayaran');
        $payment_status->addValidator(new PresenceOf(['message'=>'Status Pembayaran belum diisi']));

        $submit = new Submit ('Simpan',
        [
            'name' => 'Simpan',
            "class" => "btn btn-success"
        ]);

        $this->add($order_id);
        $this->add($payment_status);
        $this->add($submit);
    }
}