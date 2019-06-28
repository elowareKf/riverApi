<?php

require './models/Section.php';
require './models/River.php';
require 'RiverRepository.php';
require 'Settings.php';

class DbConnection
{
    private $connection;
    private $settings;

    public $riverRepository;

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

        $this->riverRepository = new RiverRepository($this->connection);
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


    public function addSection($riverId, $sectionName)
    {
        if ($this->connection == null) {
            return "Database not connected";
        }

    }

}
