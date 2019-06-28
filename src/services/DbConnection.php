<?php

require './models/Section.php';
require './models/River.php';

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

class DbConnection
{
    private $connection;
    private $settings;


    public function __construct()
    {
        $this->settings = new Settings();


        $mysql = new mysqli(
            $this->settings->server,
            $this->settings->user,
            $this->settings->password,
            $this->settings->database,
            $this->settings->port);
        if (!$mysql) {
            echo("An error occurred on connecting to the database");
            echo(mysqli_connect_error());
            $this->connection = null;
        } else $this->connection = $mysql;
    }

    public function getSection($id)
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
        while ($row = $rows->fetch_assoc()) {
            return Section::getSectionFromRow($row);
        }
        return $rows;
    }

    public function findSection($section)
    {
        if ($this->connection == null) {
            return "Database not connected";
        }

        $query = "select *, s.name as section, s.river as riverId, s.origin as sectionOrigin, s.id as sectionId " .
            "from sections s " .
            "left outer join rivers r on r.id = s.river " .
            "left outer join levelSpots l on l.id = s.levelSpot " .
            "where s.name like '%$section%'";

        $rows = $this->connection->query($query);

        $result = [];
        while ($row = $rows->fetch_assoc()) {
            array_push($result, Section::getSectionFromRow($row));
        }
        return $result;
    }

    public function findSectionAndRiver($river, $section)
    {
        if ($this->connection == null) {
            return "Database not connected";
        }

        $query = "select *, s.name as section, s.river as riverId, s.origin as sectionOrigin, s.id as sectionId " .
            "from sections s " .
            "left outer join rivers r on r.id = s.river " .
            "left outer join levelSpots l on l.id = s.levelSpot " .
            "where r.name like '%$river%' or s.name like '%$section%'";

        $rows = $this->connection->query($query);

        $result = [];
        while ($row = $rows->fetch_assoc()) {
            array_push($result, Section::getSectionFromRow($row));
        }
        return $result;
    }

    private function getSectionsForRiver($id)
    {
        $query = "select *, id as sectionId, name as section, " .
            " $id as riverId, " .
            "origin as sectionOrigin from sections where river = $id";
        $rows = $this->connection->query($query);

        $result = [];
        while ($row = $rows->fetch_assoc()) {
            array_push($result, Section::getSectionFromRow($row));
        }
        return $result;
    }

    public function getRiver($id)
    {
        if ($this->connection == null) {
            return "Database not connected";
        }

        $query = "select * from rivers where id = $id";

        $rows = $this->connection->query($query);
        $river = null;
        while ($row = $rows->fetch_assoc()) {
            $river = River::getFromRow($row);
        }

        if ($river != null) {
            $river->sections = $this->getSectionsForRiver($id);
        }

        return $river;

    }

    public function addSection($riverId, $sectionName)
    {
        if ($this->connection == null) {
            return "Database not connected";
        }

    }

    public function addRiver($riverName)
    {
        if ($this->connection == null) {
            return "Database not connected";
        }

        $query = "insert into rivers (name) values ('$riverName')";
        echo $query;
    }

    public function findRivers($search)
    {
        if ($this->connection == null) {
            return "Database not connected";
        }

        $query = "select * from rivers where name like '%$search%'";

        $rows = $this->connection->query($query);

        $result = [];
        while ($row = $rows->fetch_assoc()) {
            array_push($result, River::getFromRow($row));
        }
        return $result;
    }

    public function updateRiver($riverId, River $river)
    {
        if ($this->connection == null) {
            return "Database not connected";
        }

        $query = "update rivers set name = '{$river->name}', countries = '{$river->countries}', grades = '{$river->grades}' where id = {$riverId}";
        $this->connection->query($query);
    }
}
