<?php

namespace Classes\Service;

class ValidationService
{
    private $registrationDataRaw; //\Classes\Model\RegistrationData
    private $registrationDataValid; //\Classes\Model\RegistrationData

    /**
     * @param \Classes\Model\RegistrationData [$registrationDataInput].
     */
    public function __construct($registrationDataInput)
    {
        $this->registrationDataRaw = $registrationDataInput;
        $this->registrationDataValid = new \Classes\Model\RegistrationData();
    }

    public function indexAction()
    {
        $this->view->setVars([]);
    }

    public function isEmailValid()
    {

        $emailAdress = $this->registrationDataRaw->emailAdress;
        if (empty($emailAdress) || !filter_var($emailAdress, FILTER_VALIDATE_EMAIL)) {
            return false;
        } else {
            $this->registrationDataValid->emailAdress = $emailAdress;
            return true;
        }
    }

    public function isNameValid()
    {
        $name = $this->registrationDataRaw->name;
        $firstName = $this->registrationDataRaw->firstName;
        if (empty($name) || empty($firstName) || $name == " " || $firstName == " ") {
            return false;
        } else {
            $this->registrationDataValid->name = $name;
            $this->registrationDataValid->firstName = $firstName;
            return true;
        }
    }
    
    public function isUsernameValid()
    {
        $username = $this->registrationDataRaw->username;
        
        if (empty($username) ||  $username === " ") {
            return false;
        } else {
            $db = \Classes\Model\DatabaseModel::getInstance();
            $dbConnection = $db->getConnection();

            $erg = $dbConnection->query("SELECT username FROM user WHERE username = '$username'");

            if ($erg->num_rows === 0) {
                $this->registrationDataValid->username = $username;
                return true;
            } else {
                return false;
            }
        }
    }

    public function setUsername()
    {
        $this->registrationDataValid->username = $this->registrationDataRaw->username;
    }
    
    public function isPasswordValid()
    {
        $password = $this->registrationDataRaw->password;
        if (preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $password)) {
            $this->registrationDataValid->password = $this->registrationDataRaw->password;
            return true;
        } else {
            return false;
        }
    }

    public function validateBirthdate()
    {
        $birthdate = $this->registrationDataRaw->birthdate;
        if (empty($birthdate) ||  $birthdate == " ") {
            return false;
        } else {
            $birthdate = $this->registrationDataRaw->birthdate;


            $birthdate_pieces = explode("-", $birthdate);



            $check = checkdate($birthdate_pieces[1], $birthdate_pieces[2], $birthdate_pieces[0]); // Reihenfolge checkdate: Monat, Tag, Jahr

            if ($check === true) {
                if ((date("Y") - $birthdate_pieces[0] < 0)) {
                    return false;
                } else {
                    $this->registrationDataValid->birthdate = $birthdate;
                    return true;
                }
            } else {
                echo "Funktion wird nicht richtig ausgeführt";
                return false;
            }
        }
    }

    public function isRegistrationValid()
    {
        if ($this->registrationDataValid->username === "" ||
     $this->registrationDataValid->password === "" ||
     $this->registrationDataValid->birthdate === ""||
     $this->registrationDataValid->emailAdress === "" ||
     $this->registrationDataValid->firstName === "" ||
     $this->registrationDataValid->name === "") {
            return false;
        } else {
            return true;
        }
    }

    public function getRegistrationDataValid()
    {
        return $this->registrationDataValid;
    }
}
