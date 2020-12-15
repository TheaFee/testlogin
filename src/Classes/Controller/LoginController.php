<?php

namespace Classes\Controller;

class LoginController implements Controller
{
    public function setView(\Classes\View\BaseView $view)
    {
        $this->view = $view;
    }

    public function loginAction()
    {   //$userdata = new \Classes\Model\RegistrationData();

        $username = $_POST["username"];
        $password = $_POST["password"];
        
        $login = new \Classes\Model\LoginData();
        // die();
        if ($login->getUserLogin($_POST["username"], $_POST["password"])) {
            $this->view->setVars($_SESSION);
            header("Location:index.php?_url=Welcome/welcome");
            return true;
            
        } else {
            // die();
            header("Location:index.php?_url=Index/Index/&_login=false");
            return false;
        }
    }
}
