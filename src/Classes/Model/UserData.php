<?php

namespace Classes\Model;

class UserData{

    public function getSESSION(){
        $db = \Classes\Model\DatabaseModel::getInstance();
        $dbConnection = $db->getConnection();
        
        $username = $_SESSION;

    }

}