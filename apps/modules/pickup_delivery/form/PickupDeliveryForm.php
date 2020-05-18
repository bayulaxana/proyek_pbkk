<?php

namespace ServiceLaundry\PickupDelivery\Forms\Web;

use ServiceLaundry\Common\Forms\BaseForm;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Date;

use Phalcon\Tag;

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Digit;
use Phalcon\Validation\Validator\Alpha;

class PickupDeliveryForm extends BaseForm
{
    public function initialize()
    {
        $order_id = new Text('order_id', [
            'placeholder'   => 'Masukkan Order Id',
            'class'         => 'form-control'
        ]);
        $order_id->setLabel('Order Id');
        $order_id->addValidator(new PresenceOf(['message'=>'Order Id belum diisi']));

        $pd_status = new Text('pd_status', [
            'placeholder'   => 'Masukkan Status Pickup Delivery',
            'class'         => 'form-control'
        ]);
        $pd_status->setLabel('Status Pickup Delivery');
        $pd_status->addValidator(new PresenceOf(['message'=>'Status Pickup Delivery belum diisi']));

        $pd_driver = new Text('pd_driver', [
            'placeholder'   => 'Masukkan Nama Driver',
            'class'         => 'form-control'
        ]);
        $pd_driver->setLabel('Nama Driver');
        $pd_driver->addValidator(new PresenceOf(['message'=>'Nama Driver belum diisi']));
        $pd_driver->addValidator(new Alpha(['message'=>'Nama Driver hanya terdiri dari huruf']));

        $pd_type = new Text('pd_type', [
            'placeholder'   => 'Masukkan Tipe Pickup Delivery',
            'class'         => 'form-control'
        ]);
        $pd_type->setLabel('Tipe Pickup Delivery');
        $pd_type->addValidator(new PresenceOf(['message'=>'Tipe Pickup Delivery']));
        $pd_type->addValidator(new Alpha(['message'=>'Tipe Pickup Delivery hanya terdiri dari huruf']));

        $pd_time_est = new Date('pd_time_est', [
            'placeholder'   => 'Pilih tanggal dan waktu',
            'class'         => 'form-control'
        ]);
        $pd_time_est->setLabel('Estimasi Tanggal dan Waktu Pickup Delivery');
        $pd_time_est->addValidator(new PresenceOf(['message'=>'Estimasi Tanggal dan Waktu Pickup Delivery belum diisi']));
        
        $submit = new Submit ('Simpan',
        [
            'name' => 'Simpan',
            "class" => "btn btn-success"
        ]);
        
        $this->add($order_id);
        $this->add($pd_status);
        $this->add($pd_driver);
        $this->add($pd_type);
        $this->add($pd_time_est);
        $this->add($submit);
    }
}