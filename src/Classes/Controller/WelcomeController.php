<?php

namespace Classes\Controller;

class WelcomeController implements Controller
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

    public function welcomeAction()
    {
        $userData = new \Classes\Model\UserData();
        $userData->getSESSION();
        $this->view->setVars($_SESSION);
    }
}
