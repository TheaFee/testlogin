<?php

namespace Classes\Model;

class UpdateUserdataData
{
    public function getSESSION()
    {
        $db = \Classes\Model\DatabaseModel::getInstance();
        $dbConnection = $db->getConnection();

        $newUsername = $_SESSION;
    }

    public function updateUserData($userdata, $userID) //
    {
        $db = \Classes\Model\DatabaseModel::getInstance();
        $dbConnection = $db->getConnection();

        $var = $dbConnection->query("UPDATE user 
        SET username ='$userdata->username', name = '$userdata->name', firstName = '$userdata->firstName', 
        emailAdress = '$userdata->emailAdress', password = '$userdata->password', birthdate = '$userdata->birthdate'
        WHERE userID = '$userID'"); 

        if ($dbConnection->affected_rows === 1) {
            $_SESSION["username"] = $userdata->username;
            $_SESSION["name"] =  $userdata->name;
            $_SESSION["firstName"] = $userdata->firstName;
            $_SESSION["birthdate"] = $userdata->birthdate;
            $_SESSION["emailAdress"] = $userdata->emailAdress;
            $_SESSION["password"] = $userdata->password;
           
            header("Location: index.php?_url=Welcome/welcome");
            return true;
        } else {
            echo $dbConnection->error;
            return false;
        }
    }
}
