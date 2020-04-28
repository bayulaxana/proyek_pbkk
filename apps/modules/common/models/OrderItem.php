<?php

namespace ServiceLaundry\Order\Models\Web;

use Phalcon\Mvc\Model;

class OrderItem extends Model
{
    private $item_id;
    private $order_id;

    public function initialize()
    {
        $this->setSource('Order_Item');
    }

    public function construct($item_id,$order_id)
    {
        $this->item_id      = $item_id;
        $this->order_id     = $order_id;
    }

    public function getItemId()
    {
        return $this->item_id;
    }

    public function getOrderId()
    {
        return $this->order_id;
    }
}