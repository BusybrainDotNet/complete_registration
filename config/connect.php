<?php
/*
Project Name: Live Chat Apllication
App Version: 1.0
Author: https://github.com/BusybrainDotNet
--------------------------------------------------------------------
 * Base Site URL
---------------------------------------------------------------------
 * URL to your project root. Typically this will be your base URL:
*/
 define('BASE_URL', 'http://livechat.test/');
/**--------------------------------------------------------------------
 * Database Connection
---------------------------------------------------------------------
 *  Class for database connection
*/
class dbConnect
{
//Define connection variables
    private $server = "mysql:host=localhost;dbname=livechat";
    private $user = "root";
    private $pass = "";
    private $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    );
    public $con;   
 /* Function for opening connection */
    public function openConnection()
    {
        try {
            $this->con = new PDO($this->server, $this->user, $this->pass, $this->options);
            return $this->con;
        } catch (PDOException $e) {
            echo "There is some problem in connection: " . $e->getMessage();
        }
    }
/* Function for closing connection */
    public function closeConnection()
    {
        $this->con = null;
    }
}
