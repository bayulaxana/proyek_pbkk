<?php

namespace ServiceLaundry\Order\Models\Web;

use Phalcon\Mvc\Model;

class Item extends Model
{
    private $item_id;
    private $user_id;
    private $item_details;
    private $item_type;

    public function initialize()
    {
        $this->setSource('Item');
    }

    public function construct($user_id,$item_details,$item_type)
    {
        $this->user_id          = $user_id;
        $this->item_details     = $item_details;
        $this->item_type        = $item_type;
    }

    public function getId()
    {
        return $this->item_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }
}