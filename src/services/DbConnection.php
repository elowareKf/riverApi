<?php


class DbConnection
{
    private $connection;

    private $server = "localhost";
    private $port = 3306;
    private $database = "paddle_center";
    private $user = "root";
    private $password = "mysql.1";


    public function  __construct()
    {
        $this->connection = new mysqli($this->server,$this->user,$this->password,$this->database, $this->port);
        $this->connection->connect();
    }

    public function saveData(levelMeasurement $levelMeasurement){

    }

    public function isLatest(levelMeasurement $levelMeasurement){
        $url = $this->connection->real_escape_string($levelMeasurement->firebaseUrl);
        $query = "select * from levelSpots where levelSpotUrl = '$url'";
        $result = $this->connection->query($query);

        $row = $result->fetch_row();

        if ( $row == null) return null;


    }
}