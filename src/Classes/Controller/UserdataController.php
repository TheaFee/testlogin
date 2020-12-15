<?php

namespace Classes\Controller;

class UserdataController implements Controller
{
    /**
       * @var \Classes\View\BaseView
       */
    protected $view;

    /**
     * Die zugehörige View wird gesetzt.
     * @param \Classes\View\BaseView $view übergebene View
     */
    public function setView(\Classes\View\BaseView $view)
    {
        $this->view = $view;
    }
    public function userdataAction()
    {
        $userData = new \Classes\Model\UserData();
        $userData->getSESSION();
        //print_r($_SESSION);

        $this->view->setVars($_SESSION);
    }
}
