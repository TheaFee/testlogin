<?php

namespace Classes\Controller;

class RegistrationController implements Controller
{
    public function setView(\Classes\View\BaseView $view)
    {
        $this->view = $view;
    }

    public function registrationAction()
    {
        $user = new \Classes\Model\RegistrationData();

        $this->view->setVars(\Classes\Model\RegistrationData::getArrayFromRegistrationData($user));
        
        if (isset($_POST['submit'])) {
            $this->view->setVars(["submit" => true]);

            
            $registrationData = \Classes\Model\RegistrationData::getRegistrationDataFromArray($_POST);

            $validation = new \Classes\Service\ValidationService($registrationData);

            $validation->isEmailValid();
            $validation->isNameValid();
            $validation->isUsernameValid();
            $validation->isPasswordValid();
            $validation->validateBirthdate();
            
            $this->view->setVars(\Classes\Model\RegistrationData::getArrayFromRegistrationData($validation->getRegistrationDataValid()));
            
            if ($validation->isRegistrationValid()) {
                $user->insertUserdata($validation->getRegistrationDataValid());
                header("Location: index.php?_url=Welcome/welcome");

                return true;
            } else {
                return "Fehlermeldung - insertUserdata hat nicht geklappt";
            }
        }
    }
}
