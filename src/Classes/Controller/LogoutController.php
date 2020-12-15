<?php

namespace Classes\Controller;

class LogoutController implements Controller{

    public function setView(\Classes\View\BaseView $view)
    {
        $this->view = $view;
    }

      public function logoutAction(){

       session_destroy();
    }
}