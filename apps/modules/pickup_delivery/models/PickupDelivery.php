<?php

namespace ServiceLaundry\PickupDelivery\Models\Web;

use Phalcon\Mvc\Model;

class PickupDelivery extends Model
{
    private $pd_id;
    private $order_id;
    private $pd_status;
    private $pd_driver;
    private $pd_type;
    private $pd_time_est;

    public function initialize()
    {
        $this->setSource('Pickup_Delivery');
    }

    public function construct($order_id,$pd_status,$pd_driver,$pd_type,$pd_time_est)
    {
        $this->order_id         = $order_id;
        $this->pd_status        = $pd_status;
        $this->pd_driver        = $pd_driver;
        $this->pd_type          = $pd_type;
        $this->pd_time_est      = $pd_time_est;
    }

    public function getId()
    {
        return $this->pd_id;
    }

    public function getOrderId()
    {
        return $this->order_id;
    }

    public function getPdStatus()
    {
        return $this->pd_status;
    }

    public function getPdDriver()
    {
        return $this->pd_driver;
    }

    public function getPdType()
    {
        return $this->pd_type;
    }

    public function getPdTimeEst()
    {
        return $this->pd_time_est;
    }
}