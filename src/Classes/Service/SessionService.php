<?php
namespace Classes\Service;

class SessionService
{
    public static function checkExistingLogin()
    {
        session_start();

        if (!isset($_SESSION["userID"])) {
            
            return false;
        }else{
            return true;
        }
    }

    public static function automaticLogout()
    {
        $checkLogin = \Classes\Service\SessionService::checkExistingLogin();

        if ($checkLogin === true) {

            $sessionTimeout = 300; // 5 Minuten

            if (!isset($_SESSION["lastVisit"])) {
                $_SESSION["lastVisit"] = time();
            }

            if ((time() - $_SESSION["lastVisit"]) > $sessionTimeout) {
                session_destroy();
                header("Location: index.php?_url=Logout/logout");
            }

            $_SESSION["lastVisit"] = time();
        }
    }
}
