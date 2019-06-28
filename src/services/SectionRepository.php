<?php


class SectionRepository
{
    private $connection;

    public function __construct($conection)
    {
        $this->connection = $conection;
    }

    public function get($id)
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

    public function find($section)
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

    public function add($riverId, $sectionName)
    {
        if ($this->connection == null) {
            return "Database not connected";
        }

    }

}
