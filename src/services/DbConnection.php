<?php

require './models/Section.php';

class DbConnection
{
    private $pdo;
    private $connection;

    private $server = "database";
    private $port = 3306;
    private $database = "paddle_center";
    private $user = "root";
    private $password = "mysql.1";


    public function __construct()
    {
        $mysql = new mysqli($this->server, $this->user, $this->password, $this->database, $this->port);
        if (!$mysql) {
            echo("An error occurred on connecting to the database");
            echo(mysqli_connect_error());
            $this->connection = null;
        } else $this->connection = $mysql;
    }

    public function getSection(int $id)
    {
        if ($this->connection == null) {
           // echo("Database not initialized");
            return "Database not connected";
        }
        //else
           // echo("Calling database for section");

        $query = "select * " .
            "from sections s " .
            "left outer join rivers r on r.id = s.river " .
            "left outer join levelSpots l on l.id = s.levelSpot " .
            "where s.id = $id";

        $rows = $this->connection->query($query);
        while($row = $rows->fetch_row()){
            //echo ($row[1] .  "\r\n");

            $section = new Section();
            $section->name = $row[8];
            return $section;
        }
        return $rows;
    }


    public function saveData(LevelMeasurement $levelMeasurement)
    {

    }

    public function isLatest(LevelMeasurement $levelMeasurement)
    {
        // $url = $this->connection->real_escape_string($levelMeasurement->firebaseUrl);
        $query = "select * from levelSpots where levelSpotUrl = '.$levelMeasurement->firebaseUrl.'";
        $result = $this->connection->fetchRow($query);

        //$row = $result->fetch_row();

        if ($result == null) return null;

        return $result;

    }
}
