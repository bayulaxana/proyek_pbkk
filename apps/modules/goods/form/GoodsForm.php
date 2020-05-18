<?php

namespace ServiceLaundry\Goods\Forms\Web;

use ServiceLaundry\Common\Forms\BaseForm;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\Submit;

use Phalcon\Tag;

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Digit;

class GoodsForm extends BaseForm
{
    public function initialize()
    {
        $goods_name = new Text('goods_name', [
            'placeholder'   => 'Masukkan Nama Barang',
            'class'         => 'form-control'
        ]);
        $goods_name->setLabel('Nama Barang');
        $goods_name->addValidator(new PresenceOf(['message'=>'Nama Barang belum diisi']));

        $unit_price = new Text('unit_price', [
            'placeholder'   => 'Masukkan Harga Satuan Barang',
            'class'         => 'form-control'
        ]);
        $unit_price->setLabel('Harga Satuan Barang');
        $unit_price->addValidator(new PresenceOf(['message'=>'Harga Satuan Barang belum diisi']));

        $good_stock = new Text('good_stock', [
            'placeholder'   => 'Masukkan Stok Barang',
            'class'         => 'form-control'
        ]);
        $good_stock->setLabel('Stok Barang');
        $good_stock->addValidator(new PresenceOf(['message'=>'Stock Barang belum diisi']));
        $good_stock->addValidator(new Digit(['message'=>'Stock Barang hanya berisi angka']));
        
        $submit = new Submit ('Simpan',
        [
            'name' => 'Simpan',
            "class" => "btn btn-success"
        ]);

        $this->add($goods_name);
        $this->add($unit_price);
        $this->add($good_stock);
        $this->add($submit);
    }
}