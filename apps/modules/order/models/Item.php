<?php

namespace ServiceLaundry\Order\Models\Web;

use Phalcon\Mvc\Model;

class Item extends Model
{
    private $item_id;
    private $user_id;
    private $item_details;
    private $item_type;
    private $item_photo;

    public function initialize()
    {
        $this->setSource('Item');
    }

    public function construct($user_id,$item_details,$item_type,$item_photo)
    {
        $this->user_id          = $user_id;
        $this->item_details     = $item_details;
        $this->item_type        = $item_type;
        $this->item_photo       = $item_photo;
    }

    public function getId()
    {
        return $this->item_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getItemDetails()
    {
        return $this->item_details;
    }

    public function getItemType()
    {
        return $this->item_type;
    }

    public function getItemPhoto()
    {
        return $this->item_photo;
    }
}