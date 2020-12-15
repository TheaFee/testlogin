<?php

namespace Classes\Model;

class DatabaseModel
{
    private static $instance;
    private $db;

    private function __construct()
    {
    }
    private function __clone()
    {
    }


    public function getConnection()
    {
        error_reporting(E_ALL); // in Produktivumgebung auf error_reporting(0); stellen, zum Testen auf error_reporting(E_ALL);

        $db = new \mysqli('localhost', 'root', 'root', "testseite"); // Server, Benutzername, Kennwort, Name Datenbank
        
        print_r($db->connect_error);

        if ($db->connect_errno) {
            die("Sorry - gerade gibt es ein Problem");
        }

        return $db;
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            // Erstelle eine neue Instanz, falls noch keine vorhanden ist.
            self::$instance = new self();
        }
 
        // Liefere immer die selbe Instanz.
        return self::$instance;
    }
}
