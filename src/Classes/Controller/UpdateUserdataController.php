<?php

namespace Classes\Controller;

class UpdateUserdataController implements Controller
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

    public function updateUserdataAction()
    {
        $userData = new \Classes\Model\UpdateUserdataData();
        $userData->getSESSION();
        // print_r($_SESSION);

        $this->view->setVars($_SESSION);
        
        if (isset($_POST['submit'])) {
            $this->view->setVars(["submit" => true]);
            $newData = new \Classes\Model\RegistrationData();
            $newData->username = $_POST["username"];
            $newData->password = $_POST["password"];
            $newData->firstName = $_POST["firstName"];
            $newData->name = $_POST["name"];
            $newData->birthdate = $_POST["birthdate"];
            $newData->emailAdress = $_POST["emailAdress"];

            $userID = $_SESSION["userID"];

            $validation = new \Classes\Service\ValidationService($newData);

            $validation->isEmailValid();
            $validation->isNameValid();
            $validation->isPasswordValid();
            $validation->validateBirthdate();

            if($newData->username === $_SESSION["username"]){
                $validation->setUsername();
            }else{
                $validation->isUsernameValid();
            }

            $this->view->setVars(\Classes\Model\RegistrationData::getArrayFromRegistrationData($validation->getRegistrationDataValid()));

            if ($validation->isRegistrationValid()) {
                $user = new \Classes\Model\updateUserdataData();
                $user->updateUserdata($validation->getRegistrationDataValid(), $userID);
                header("Location: index.php?_url=Welcome/welcome");
                return true;
            }
        }
    }
}
