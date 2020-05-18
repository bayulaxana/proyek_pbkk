<?php

namespace ServiceLaundry\Dashboard\Forms\Web;

use ServiceLaundry\Common\Forms\BaseForm;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Radio;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\File;

use Phalcon\Tag;

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\Alpha;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Digit;

class UserForm extends BaseForm 
{
    public function initialize()
    {
        $username = new Text('username', 
        [
            'placeholder'   => 'Masukkan username',
            'class'         => 'form-control'
        ]);
        $username->setLabel('Username');
        $username->addValidator(new PresenceOf(['message'=>'Username belum diisi']));

        $password = new Password('password', 
        [
            'placeholder'   => 'Masukkan Password',
            'class'         => 'form-control'
        ]);
        $password->setLabel('Password');
        $password->addValidator(new PresenceOf(['message'=>'Password belum diisi']));
        $password->addValidator(new Regex(
                [
                    'pattern'=>'/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/',
                    'message'=>'Password minimum terdiri dari 8 karakter, paling sedikit satu huruf dan satu angka' 
                ]
        ));

        $name = new Text('name',
        [
            'placeholder'   => 'Masukkan nama',
            'class'         => 'form-control'
        ]);
        $name->setLabel('Nama');
        $name->addValidator(new PresenceOf(['message'=>'Nama belum diisi']));
        $name->addValidator(new Alpha(['message'=>'Nama hanya terdiri dari huruf']));

        $jk_perempuan = new Radio('P',
        [
            'name' => 'gender',
            'value' => 'P'
        ]);
        $jk_perempuan->setLabel('Perempuan');

        $jk_laki = new Radio('L',
        [
            'name' => 'gender',
            'value' => 'L'
        ]);
        $jk_laki->setLabel('Laki-laki');
        
        $address = new Text('address',
        [
            'placeholder'   => 'Masukkan alamat',
            'class'         => 'form-control'
        ]);
        $address->setLabel('Alamat');
        $address->addValidator(new PresenceOf(['message'=>'Alamat belum diisi']));

        $phone = new Text('phone',
        [
            'placeholder'   => 'Masukkan nomor telepon',
            'class'         => 'form-control'
        ]);
        $phone->setLabel('Nomor Telepon');
        $phone->addValidator(new PresenceOf(['message'=>'Nomor telepon belum diisi']));
        $phone->addValidator(new Digit(['message'=>'Nomor telepon hanya terdiri dari angka']));

        $email = new Text('email',
        [
            'placeholder'   => 'Masukkan email',
            'class'         => 'form-control'
        ]);
        $email->setLabel('Email');
        $email->addValidator(new PresenceOf(['message'=>'Email belum diisi']));
        $email->addValidator(new Email(['message'=>'Email tidak valid']));
        
        $profile_img = new File('profile_img',
        [
            'placeholder'   => 'Cari File',
            'class'         => 'form-control'
        ]);
        $profile_img->setLabel('Tambah Foto');
        $profile_img->addValidator(new PresenceOf(['message'=>'Foto belum diisi']));

        $submit = new Submit ('Simpan',
        [
            'name' => 'Simpan',
            "class" => "btn btn-success"
        ]);

        $this->add($username);
        $this->add($password);
        $this->add($name);
        $this->add($jk_perempuan);
        $this->add($jk_laki);
        $this->add($address);
        $this->add($phone);
        $this->add($email);
        $this->add($profile_img);
        $this->add($submit);
    }
}
