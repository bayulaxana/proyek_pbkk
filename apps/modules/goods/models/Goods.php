<?php

namespace ServiceLaundry\Goods\Models\Web;

use Phalcon\Mvc\Model;

class Goods extends Model
{
    private $goods_id;
    private $admin_id;
    private $goods_name;
    private $unit_price;
    private $good_stock;

    public function initialize()
    {
        $this->setSource('Goods');
    }

    public function construct($admin_id,$goods_name,$unit_price,$good_stock)
    {
        $this->admin_id         = $admin_id;
        $this->goods_name       = $goods_name;
        $this->unit_price       = $unit_price;
        $this->good_stock       = $good_stock;
    }

    public function getId()
    {
        return $this->goods_id;
    }

    public function getGoodsName()
    {
        return $this->goods_name;
    }

    public function getUnitPrice()
    {
        return $this->unit_price;
    }

    public function getGoodStock()
    {
        return $this->good_stock;
    }
}