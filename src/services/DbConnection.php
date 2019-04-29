<?php

use Simplon\Mysql\Mysql;
use Simplon\Mysql\PDOConnector;


class DbConnection
{
    private $pdo;
    private $connection;

    private $server = "localhost";
    private $port = 3306;
    private $database = "paddle_center";
    private $user = "root";
    private $password = "mysql.1";


    public function  __construct()
    {
        $this->pdo = new PDOConnector($this->server,
            $this->user,
            $this->password,
            $this->database);

        $this->connection = new Mysql( $this->pdo->connect('utf8', []));

    }

    public function saveData(LevelMeasurement $levelMeasurement){

    }

    public function isLatest(LevelMeasurement $levelMeasurement){
        // $url = $this->connection->real_escape_string($levelMeasurement->firebaseUrl);
        $query = "select * from levelSpots where levelSpotUrl = '.$levelMeasurement->firebaseUrl.'";
        $result = $this->connection->fetchRow($query);

        //$row = $result->fetch_row();

        if ( $result == null) return null;

        return $result;

    }
}
