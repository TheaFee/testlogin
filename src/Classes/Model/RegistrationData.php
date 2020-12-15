<?php

namespace Classes\Model;

class RegistrationData
{
    public string $username;
    public string $password;
    public string $birthdate;
    public string $emailAdress;
    public string $firstName;
    public string $name;
   
    public function __construct()
    {
        $this->username = "";
        $this->password = "";
        $this->birthdate = "";
        $this->emailAdress = "";
        $this->firstName = "";
        $this->name = "";
    }
    public static function getRegistrationDataFromArray(array $array)
    {
        $registrationData = new RegistrationData();
        $registrationData->username = $array["username"];
        $registrationData->password = $array["password"];
        $registrationData->firstName = $array["firstName"];
        $registrationData->name = $array["name"];
        $registrationData->birthdate = $array["birthdate"];
        $registrationData->emailAdress = $array["emailAdress"];
        return $registrationData;
    }

    public static function getArrayFromRegistrationData(RegistrationData $registrationDataObject)
    {
        return [
          "username" => $registrationDataObject->username,
          "password" => $registrationDataObject->password,
          "firstName" => $registrationDataObject->firstName,
          "name" => $registrationDataObject->name,
          "birthdate" => $registrationDataObject->birthdate,
          "emailAdress" => $registrationDataObject->emailAdress
        ];
    }

    public function insertUserdata($userdata) //
    {
        $db = \Classes\Model\DatabaseModel::getInstance();
        $dbConnection = $db->getConnection();

        $var = $dbConnection->query("INSERT INTO user (username, name, firstName, emailAdress, password, birthdate) 

         VALUES ('$userdata->username', '$userdata->name', '$userdata->firstName', '$userdata->emailAdress', '$userdata->password', '$userdata->birthdate')");
      
        if ($dbConnection->affected_rows) {

            $_SESSION["username"] = $userdata->username;
            $_SESSION["name"] =  $userdata->name;
            $_SESSION["firstName"] = $userdata->firstName;
            $_SESSION["birthdate"] = $userdata->birthdate;
            $_SESSION["emailAdress"] = $userdata->emailAdress;
            $_SESSION["password"] = $userdata->password;
            $_SESSION["userID"] =  $dbConnection->insert_id;

            return true;
        } else {
             echo $dbConnection->error;
            return false;
        }
    }
}
