<?php

namespace ServiceLaundry\Order\Models\Web;

use Phalcon\Mvc\Model;

class Payment extends Model
{
    private $payment_id;
    private $order_id;
    private $admin_id;
    private $payment_status;
    private $payment_time;

    public function initialize()
    {
        $this->setSource('Payment');
    }

    public function construct($order_id,$admin_id,$payment_status,$payment_time)
    {
        $this->order_id         = $order_id;
        $this->admin_id         = $admin_id;
        $this->payment_status   = $payment_status;
        $this->payment_time     = $payment_time;
    }

    public function getId()
    {
        return $this->payment_id;
    }

    public function getOrderId()
    {
        return $this->order_id;
    }

    public function getPaymentStatus()
    {
        return $this->payment_status;
    }

    public function getPaymentTime()
    {
        return $this->payment_time;
    }
}