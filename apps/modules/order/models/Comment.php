<?php

namespace ServiceLaundry\Order\Models\Web;

use Phalcon\Mvc\Model;

class Comment extends Model
{
    private $comment_id;
    private $user_id;
    private $comment_content;
    private $comment_status;
    private $comment_date;
    private $order_id;

    public function initialize()
    {
        $this->setSource('Comment');
    }

    public function construct($user_id,$comment_content,$comment_status,$comment_date,$order_id)
    {
        $this->user_id              = $user_id;
        $this->comment_content      = $comment_content;
        $this->comment_status       = $comment_status;
        $this->comment_date         = $comment_date;
        $this->order_id             = $order_id;
    }

    public function getId()
    {
        return $this->item_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getContent()
    {
        return $this->comment_content;
    }

    public function getStatus()
    {
        return $this->comment_status;
    }

    public function getDate()
    {
        return $this->comment_date;
    }

    public function getOrderId()
    {
        return $this->order_id;
    }
}