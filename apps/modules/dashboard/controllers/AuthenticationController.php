<?php

namespace ServiceLaundry\Dashboard\Controllers\Web;

use ServiceLaundry\Common\Controllers\SecureController;
use ServiceLaundry\Dashboard\Forms\Web\LoginForm;
use ServiceLaundry\Dashboard\Forms\Web\UserForm;
use ServiceLaundry\Dashboard\Models\Web\Users;
use ServiceLaundry\Order\Models\Web\Service;
use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;


class AuthenticationController extends SecureController
{
    public $msg_error      = array();
    public $msg_success    = array();

    public function initialize()
    {
        $this->setFlashSessionDesign();
    }

    public function homeAction()
    {
        $this->view->service = Service::find();
        $this->view->pick('views/home');
    }
    
    public function createLoginAction()
    {
        $this->view->form           = new LoginForm();
        $this->view->forms          = new UserForm();
        $this->view->flash          = $this->flash; 
        $this->view->msg_success    = $msg_success;
        $this->view->msg_error      = $msg_error;
        $this->view->pick('views/createLogin');
    }

    public function storeLoginAction()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember');

        $user = Users::findFirst("username='$username'");
        if($user)
        {
            if($this->security->checkHash($password, $user->getPassword()))
        	{
        		$this->session->set('auth',
        			[
                        'username'  => $username,
                        'id'        => $user->getId(),
                        'remember'  => $remember,
                        'role'      => $user->getRole()
        			]
                );

                $remCookies = $username."+".$password;
                
                if($remember==1){
                    $this->cookies->set("remember",$remCookies, time() + 15 * 86400);
                    $this->cookies->send();
                    setcookie("remember", $remCookies, (86400 * 15), '/');
                }
                $user->getRole()==1 ? (new Response())->redirect()->send() :  (new Response())->redirect("home")->send();
            }
            else{
                $this->security->hash(rand());
                $this->flash->error("Password salah");
                return $this->dispatcher->forward(['action'=> 'createLogin']);
            }
        }
        else {
            if($password==="" | $username==="")
            {
                $this->flash->error("Anda harus memasukkan username dan password untuk masuk");
            }  
            else
            {
                $this->flash->error("Username dan/atau password salah.");
            }
            return $this->dispatcher->forward(['action'=> 'createLogin']);
        }
    }

    public function storeUserAction()
    {
        if(!$this->request->isPost())
        {
            $this->response->redirect();
        }

        $form = new UserForm();
        if($this->request->getPost('gender') == null)
        {
            array_push($msg_error,'Anda harus mengisi jenis kelamin');
            $this->response->redirect("login");
        }

        $username = $this->request->getPost('username');
        if(Users::findFirst("username='$username'"))
        {
            array_push($msg_error,'Username sudah digunakan');
            $this->response->redirect("login");
        }

        $flag = 0;
        if(!$form->isValid($this->request->getPost()))
        {
            foreach ($form->getMessages() as $msg)
            {
                if($msg->getMessage()!=null && $msg->getField()!='profile_img')
                {
                    $flag = 1;
                    array_push($msg_error,$msg->getMessage());
                }
            }
        }

        if($this->request->hasFiles() == true && !$flag)
        {
            $username       = $this->request->getPost('username');
            $password       = $this->security->hash($this->request->getPost('password'));
            $name           = $this->request->getPost('name');
            $gender         = $this->request->getPost('gender');
            $address        = $this->request->getPost('address');
            $register_date  = date('Y-m-d');
            $role           = 0;
            $phone          = $this->request->getPost('phone');
            $email          = $this->request->getPost('email');
            $profile_img    = "temp.jpg";

            $member = new Users();
            $member->construct($username,$password,$name,$gender,$address,$register_date,$role,$phone,$email,$profile_img);

            if($member->save())
            {
                foreach($this->request->getUploadedFiles() as $file)
                {
                    $filename_toDB  = "img_profile/" . $member->getId() . '.' .$file->getExtension();
                    $save_file      = BASE_PATH . '/public/' . $filename_toDB;
                    $file->moveTo($save_file);
                    $member->construct($username,$password,$name,$gender,$address,$register_date,$role,$phone,$email,$filename_toDB);
                    $member->update();
                }
                array_push($msg_success,'Akun Anda berhasil didaftarkan');
                $this->view->form = new UserForm();
            }
            else
            {
                array_push($msg_error,'Terjadi kesalahan saat mendaftarkan akun. Mohon, coba ulang kembali');
            }
        }
        return $this->response->redirect("login");
    }

    public function logoutAction()
    {
        unset($this->session->auth);
        $this->response->redirect("login");
    }

    public function showAccountAction()
    {
        $member_id       = $this->request->getQuery('id');
        $data           = Users::findFirst("user_id='$member_id'");

        if(!$this->session->has('auth')) $this->response->redirect("home");

        if($data == null)
        {
            $this->flashSession->error('Data Profil tidak ditemukan');
            $this->session->get('auth')['role'] == 1 ?  $this->response->redirect() : $this->response->redirect("home");
        }

        $this->view->data           = $data;
        $this->view->flashSession   = $this->flashSession;
        $this->view->pick('views/showAccount');
    }

    public function updateProfileAction()
    {
        if(!$this->request->isPost())
        {
            $this->response->redirect('profile?='.$this->session->get('auth')['id']);
        }

        $user_id        = $this->request->getPost('user_id');
        $member          = Users::findFirst("user_id='$user_id'");
        if($member == null)
        {
            $this->flashSession->error('Terjadi error saat pencarian data. Mohon coba ulang kembali');
        }
        else
        {
            $name       = $this->request->getPost('name');
            $username   = $this->request->getPost('username');
            $gender     = $this->request->getPost('gender');
            $address    = $this->request->getPost('address');
            $phone      = $this->request->getPost('phone');
            $email      = $this->request->getPost('email');

            $register_date  = $member->getRegisterDate();
            $role           = $member->getRole();
            $profile_img    = $member->getProfileImg();
            $password       = $member->getPassword();

            $member->construct($username,$password,$name,$gender,$address,$register_date,$role,$phone,$email,$profile_img);
            if($member->update())
            {
                $this->flashSession->success("Data diri berhasil diperbarui");
            }
            else
            {
                $this->flashSession->error("Data diri tidak berhasil diperbarui");
            }
        }
        $this->response->redirect('profile?id='.$member->getId());
    }

    public function changePasswordAction()
    {
        if(!$this->request->isPost())
        {
            $this->response->redirect('profile?='.$this->session->get('auth')['id']);
        }

        $user_id        = $this->request->getPost('user_id');
        $member          = Users::findFirst("user_id='$user_id'");
        $old_password   = $this->request->getPost('old_password');

        if($this->security->checkHash($old_password, $member->getPassword()))
        {
            if($member == null)
            {
                $this->flashSession->error('Terjadi error saat pencarian data. Mohon coba ulang kembali');
            }
            else
            {
                $name           = $member->getName();
                $username       = $member->getUsername();
                $gender         = $member->getGender();
                $address        = $member->getAddress();
                $phone          = $member->getPhone();
                $email          = $member->getEmail();
                $register_date  = $member->getRegisterDate();
                $role           = $member->getRole();
                $profile_img    = $member->getProfileImg();

                $password       = $this->security->hash($this->request->getPost('new_password'));
                $member->construct($username,$password,$name,$gender,$address,$register_date,$role,$phone,$email,$profile_img);
                if($member->update())
                {
                    $this->flashSession->success("Password berhasil diganti");
                }
                else
                {
                    $this->flashSession->error("Password gagal diganti");
                }
            }
        }
        $this->response->redirect('profile?id='.$member->getId());
    }

    public function changeProfilImageAction()
    {
        if(!$this->request->isPost())
        {
            $this->response->redirect('profile?='.$this->session->get('auth')['id']);
        }
        $user_id        = $this->request->getPost('user_id');
        $member          = Users::findFirst("user_id='$user_id'");

        if($member==null)
        {
            $this->flashSession->error('Terjadi error saat pencarian data. Mohon coba ulang kembali');
        }
        else
        {
            $old_file       = BASE_PATH . '/public/' .$member->getProfileImg();
            $name           = $member->getName();
            $username       = $member->getUsername();
            $gender         = $member->getGender();
            $address        = $member->getAddress();
            $phone          = $member->getPhone();
            $email          = $member->getEmail();
            $register_date  = $member->getRegisterDate();
            $role           = $member->getRole();
            $password       = $member->getPassword();

            if(!unlink($old_file))
            {
                $this->flashSession->error("File lama tidak dapat ditemukan");
            }
            else
            {
                foreach($this->request->getUploadedFiles() as $file)
                {
                    $filename_toDB  = 'img_profile/' .$user_id. '.' .$file->getExtension();
                    $save_file      = BASE_PATH . '/public/' .$filename_toDB;
                    $file->moveTo($save_file);
                    $member->construct($username,$password,$name,$gender,$address,$register_date,$role,$phone,$email,$filename_toDB);
                    $member->update();
                }
                $this->flashSession->success("Profil gambar berhasil diperbarui");
            }
        }
        $this->response->redirect('profile?id='.$member->getId());
    }
}