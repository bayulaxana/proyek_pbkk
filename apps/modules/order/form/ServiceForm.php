<?php

namespace ServiceLaundry\Order\Forms\Web;

use ServiceLaundry\Common\Forms\BaseForm;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\File;

use Phalcon\Tag;

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Digit;

class ServiceForm extends BaseForm
{
    public function initialize()
    {
        $service_name = new Text('service_name', [
            'placeholder'   => 'Masukkan Nama Service',
            'class'         => 'form-control'
        ]);
        $service_name->setLabel('Nama Service');
        $service_name->addValidator(new PresenceOf(['message'=>'Nama Service belum diisi']));

        $service_price = new Text('service_price', [
            'placeholder'   => 'Masukkan Harga Service',
            'class'         => 'form-control'
        ]);
        $service_price->setLabel('Harga Service');
        $service_price->addValidator(new PresenceOf(['message'=>'Harga Service belum diisi']));
        $service_price->addValidator(new Digit(['message'=>'Harga Service hanya berisi angka']));

        $service_photo = new File('service_photo', [
            'placeholder'   => 'Cari File',
            'class'         => 'form-control'
        ]);
        $service_photo->setLabel('Tambah Foto Service');
        $service_photo->addValidator(new PresenceOf(['message'=>'Foto Service belum ditambahkan']));

        $submit = new Submit ('Simpan',
        [
            'name' => 'Simpan',
            "class" => "btn btn-success"
        ]);

        $this->add($service_name);
        $this->add($service_price);
        $this->add($service_photo);
        $this->add($submit);
    }
}