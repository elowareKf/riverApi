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

        $query = "select *, s.river as riverId, s.origin sectionOrigin " .
            "from sections s " .
            "left outer join rivers r on r.id = s.river " .
            "left outer join levelSpots l on l.id = s.levelSpot " .
            "where s.id = $id";

        $rows = $this->connection->query($query);
        while($row = $rows->fetch_assoc()){

            $section = new Section();
            $section->grade = $row['general_grade'];
            $section->name = $row['section'];
            $section->spotGrade = $row['spot_grades'];
            $section->id = $id;
            $section->putIn = $row['latstart'].';'.$row['lngstart'];
            $section->takeOut = $row['latend'].';'.$row['lngend'];
            $section->type = $row['type'];
            $section->riverId = $row['riverId'];
            $section->origin = $row['sectionOrigin'];
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
