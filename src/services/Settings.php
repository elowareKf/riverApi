<?php


class Settings
{
    public $server = "database";
    public $port = 3306;
    public $database = "paddle_center";
    public $user = "paddle_center_admin";
    public $password = "mysql.1";

    public function __construct()
    {
        error_reporting(0);
        try {
            if (include('Credentials.php')) {
                $this->server = Credentials::$server;
                $this->port = Credentials::$port;
                $this->database = Credentials::$database;
                $this->user = Credentials::$user;
                $this->password = Credentials::$password;
            } else {
                //
            }
        } catch (Exception $e) {
        }
    }

}
