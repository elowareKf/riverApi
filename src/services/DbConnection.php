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
            return "Database not connected";
        }

        $query = "select *, s.name as section, s.river as riverId, s.origin as sectionOrigin, s.id as sectionId " .
            "from sections s " .
            "left outer join rivers r on r.id = s.river " .
            "left outer join levelSpots l on l.id = s.levelSpot " .
            "where s.id = $id";

        $rows = $this->connection->query($query);
        while($row = $rows->fetch_assoc()){
            return Section::getSectionFromRow($row);
        }
        return $rows;
    }

    public function findSection(string $river, string $section){
        if ($this->connection == null) {
            return "Database not connected";
        }

        $query = "select *, s.name as section, s.river as riverId, s.origin as sectionOrigin, s.id as sectionId " .
            "from sections s " .
            "left outer join rivers r on r.id = s.river " .
            "left outer join levelSpots l on l.id = s.levelSpot ".
        "where r.name like '%$river%' or s.name like '%$section%'";

        $rows = $this->connection->query($query);

        $result = [];
        while($row = $rows->fetch_assoc()){
            array_push($result, Section::getSectionFromRow($row));
        }
        return $result;
    }
}
