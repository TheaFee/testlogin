<?php

namespace Classes\Controller;

class IndexController implements Controller
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

    public function indexAction()
    {
        $user = new \Classes\Model\RegistrationData();

        $this->view->setVars(\Classes\Model\RegistrationData::getArrayFromRegistrationData($user));
    }
}
