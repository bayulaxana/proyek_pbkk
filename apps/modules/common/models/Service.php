<?php

namespace ServiceLaundry\Order\Models\Web;

use Phalcon\Mvc\Model;

class Service extends Model
{
    private $service_id;
    private $service_name;
    private $service_photo;
    private $service_price;

    public function initialize()
    {
        $this->setSource('Service');
    }

    public function construct($service_name,$service_photo,$service_price)
    {
        $this->service_name     = $service_name;
        $this->service_photo    = $service_photo;
        $this->service_price    = $service_price;
    }

    public function getId()
    {
        return $this->service_id;
    }

    public function getServiceName()
    {
        return $this->service_name;
    }

    public function getServicePhoto()
    {
        return $this->service_photo;
    }

    public function getServicePrice()
    {
        return $this->service_price;
    }
}