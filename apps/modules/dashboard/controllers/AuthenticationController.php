<?php

namespace ServiceLaundry\Dashboard\Controllers\Web;

use ServiceLaundry\Common\Controllers\SecureController;
use ServiceLaundry\Dashboard\Forms\Web\LoginForm;
use ServiceLaundry\Dashboard\Models\Web\Users;
use ServiceLaundry\Order\Models\Web\Service;
use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;


class AuthenticationController extends SecureController
{
    private $message = "";

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
        $this->view->form       = new LoginForm();
        $this->view->flash      = $this->flash; 
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

    public function logoutAction()
    {
        unset($this->session->auth);
        $this->response->redirect("login");
    }

    public function showAccountAction()
    {
        $admin_id       = $this->request->getQuery('id');
        $data           = Users::findFirst("user_id='$admin_id'");

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
        $admin          = Users::findFirst("user_id='$user_id'");
        if($admin == null)
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

            $register_date  = $admin->getRegisterDate();
            $role           = $admin->getRole();
            $profile_img    = $admin->getProfileImg();
            $password       = $admin->getPassword();

            $admin->construct($username,$password,$name,$gender,$address,$register_date,$role,$phone,$email,$profile_img);
            if($admin->update())
            {
                $this->flashSession->success("Data diri berhasil diperbarui");
            }
            else
            {
                $this->flashSession->error("Data diri tidak berhasil diperbarui");
            }
        }
        $this->response->redirect('profile?id='.$admin->getId());
    }

    public function changePasswordAction()
    {
        if(!$this->request->isPost())
        {
            $this->response->redirect('profile?='.$this->session->get('auth')['id']);
        }

        $user_id        = $this->request->getPost('user_id');
        $admin          = Users::findFirst("user_id='$user_id'");
        $old_password   = $this->request->getPost('old_password');

        if($this->security->checkHash($old_password, $admin->getPassword()))
        {
            if($admin == null)
            {
                $this->flashSession->error('Terjadi error saat pencarian data. Mohon coba ulang kembali');
            }
            else
            {
                $name           = $admin->getName();
                $username       = $admin->getUsername();
                $gender         = $admin->getGender();
                $address        = $admin->getAddress();
                $phone          = $admin->getPhone();
                $email          = $admin->getEmail();
                $register_date  = $admin->getRegisterDate();
                $role           = $admin->getRole();
                $profile_img    = $admin->getProfileImg();

                $password       = $this->security->hash($this->request->getPost('new_password'));
                $admin->construct($username,$password,$name,$gender,$address,$register_date,$role,$phone,$email,$profile_img);
                if($admin->update())
                {
                    $this->flashSession->success("Password berhasil diganti");
                }
                else
                {
                    $this->flashSession->error("Password gagal diganti");
                }
            }
        }
        $this->response->redirect('profile?id='.$admin->getId());
    }

    public function changeProfilImageAction()
    {
        if(!$this->request->isPost())
        {
            $this->response->redirect('profile?='.$this->session->get('auth')['id']);
        }
        $user_id        = $this->request->getPost('user_id');
        $admin          = Users::findFirst("user_id='$user_id'");

        if($admin==null)
        {
            $this->flashSession->error('Terjadi error saat pencarian data. Mohon coba ulang kembali');
        }
        else
        {
            $old_file       = BASE_PATH . '/public/' .$admin->getProfileImg();
            $name           = $admin->getName();
            $username       = $admin->getUsername();
            $gender         = $admin->getGender();
            $address        = $admin->getAddress();
            $phone          = $admin->getPhone();
            $email          = $admin->getEmail();
            $register_date  = $admin->getRegisterDate();
            $role           = $admin->getRole();
            $password       = $admin->getPassword();

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
                    $admin->construct($username,$password,$name,$gender,$address,$register_date,$role,$phone,$email,$filename_toDB);
                    $admin->update();
                }
                $this->flashSession->success("Profil gambar berhasil diperbarui");
            }
        }
        $this->response->redirect('profile?id='.$admin->getId());
    }
}