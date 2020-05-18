<?php

namespace ServiceLaundry\Dashboard\Models\Web;

use Phalcon\Mvc\Model;

class Users extends Model
{
    private $user_id;
    private $username;
    private $password;
    private $name;
    private $gender;
    private $address;
    private $register_date;
    private $role;
    private $phone;
    private $email;
    private $profile_img;

    public function initialize()
    {
        $this->setSource('Users');
    }

    public function construct($username,$password,$name,$gender,$address,$register_date,$role,$phone,$email,$profile_img)
    {
        $this->username         = $username;
        $this->password         = $password;
        $this->name             = $name;
        $this->gender           = $gender;
        $this->address          = $address;
        $this->register_date    = $register_date;
        $this->role             = $role;
        $this->phone            = $phone;
        $this->email            = $email;
        $this->profile_img      = $profile_img;
    }

    public function getId()
    {
        return $this->user_id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getRegisterDate()
    {
        return $this->register_date;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getProfileImg()
    {
        return $this->profile_img;
    }
}