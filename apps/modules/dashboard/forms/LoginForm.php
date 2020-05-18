<?php
namespace ServiceLaundry\Dashboard\Forms\Web;

use ServiceLaundry\Common\Forms\BaseForm;
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Submit;

use Phalcon\Tag;

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Alnum;

class LoginForm extends BaseForm {
    public function initialize(){
        isset($_COOKIE['remember'])? $array = explode("+",$_COOKIE['remember']) : $array=["",""];
        $username = new Text ('username',
        [
            "placeholder" => "Username",
            "class" => "form-control",
            "value" => $array[0]
        ]);
        $username->addValidator(new PresenceOf(['message'=>'Username belum diisi']));
        $username->addValidator(new Alnum(['message' => 'Username hanya terdiri dari huruf dan angka']));

        $password = new Password ('password',
        [
            "placeholder" => "Password",
            "class" => "form-control",
            "value" => $array[1]
        ]);
        $username->addValidator(new PresenceOf(['message'=>'Password belum diisi']));
        $username->addValidator(new Alnum(['message' => 'Username hanya terdiri dari huruf dan angka']));

        $cek = new Check('remember',
        [
            'value' => 1,
        ]);
        $cek->setLabel('Remember me');

        $submit = new Submit ('Login',[
            'name' => 'login',
            "class" => "btn btn-primary"
        ]);
        
        $this->setUserOptions([
            'method'=> 'POST',
            'class' => 'loginForm'
        ]);

        $this->add($username);
        $this->add($password);
        $this->add($cek);
        $this->add($submit);
    }
}