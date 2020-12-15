<?php

namespace Classes\Model;

class LoginData
{
    public function getUserLogin($username, $password)
    {
        $db = \Classes\Model\DatabaseModel::getInstance();
        $dbConnection = $db->getConnection();
        $userData = $dbConnection->query("SELECT * FROM user WHERE username = '$username' AND password = '$password'");

        $array = $userData->fetch_assoc();

        print_r($userData->num_rows);

        if ($userData->num_rows === 1) {
            session_start();

            $_SESSION["username"] = $username;
            $_SESSION["name"] = $array["name"];
            $_SESSION["firstName"] = $array["firstName"];
            $_SESSION["birthdate"] = $array["birthdate"];
            $_SESSION["emailAdress"] = $array["emailAdress"];
            $_SESSION["password"] = $array["password"];
            $_SESSION["userID"] = $array["userID"];

            return true;
        } else {
            return false;
        }
    }
}
