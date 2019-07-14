<?php

class SectionRepository
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
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

    public function add($riverId, Section $section)
    {
        if ($this->connection == null) {
            return "Database not connected";
        }

        $latStart = str_split($section->putIn)[0];
        $lngStart = str_split($section->putIn)[1];
        $latEnd = str_split($section->takeOut)[0];
        $lngEnd = str_split($section->takeOut)[1];

        $query = "insert into sections (country, general_grade, latend, latstart, lngend, lngstart, rivername, name, " .
            " spot_grades, type, origin, river, levelSpot, extLevelSpot, extLevelType, maxFlow, midFlow, minFlow, " .
            "maxLevel, midLevel, minLevel) " .
            "values ('{$section->country}', " .
            "'{$section->grade}', " .
            "'{$latEnd}', " .
            "'{$latStart}', " .
            "'{$lngEnd}', " .
            "'{$lngStart}', " .
            "'{$section->spotGrade}', " .
            "'{$section->type}', " .
            "'{$section->origin}', " .
            "{$riverId}, " .
            "'{$section->levelSpotId}', " .
            "'{$section->extLevelSpot}', " .
            "'{$section->extLevelType}', " .
            "{$section->maxFlow}, " .
            "{$section->midFlow}, " .
            "{$section->minFlow}, " .
            "{$section->maxLevel}, " .
            "{$section->midLevel}, " .
            "{$section->minLevel} " .
            ")";

        $this->connection->query($query);

        $reader = $this->connection->query("SELECT LAST_INSERT_ID()");

        if ($reader === false)
            die($this->connection->error . " Adding not successful");

        if ($row = $reader->fetch_row()) {
            $section->id = $row[0];
        }
        return $section;
    }

    public function update($sectionId, Section $section)
    {
        if ($this->connection == null) {
            return "Database not connected";
        }

        $latStart = explode(';', $section->putIn)[0];
        $lngStart = explode(';', $section->putIn)[1];
        $latEnd = explode(';', $section->takeOut)[0];
        $lngEnd = explode(';', $section->takeOut)[1];

        $query = "update sections  set " .
            "country =  '{$section->country}', " .
            "general_grade = '{$section->grade}', " .
            "latend = {$latEnd}, " .
            "latstart = {$latStart}, " .
            "lngend = {$lngEnd}, " .
            "lngstart = {$lngStart}, " .
            "spot_grades = '{$section->spotGrade}', " .
            "type = '{$section->type}', " .
            "origin = '{$section->origin}', " .
          //  "river = {$section->riverId}, " .
            "levelSpot = {$section->levelSpotId}, " .
            "extLevelSpot = '{$section->extLevelSpot}', " .
            "extLevelType = '{$section->extLevelType}', " .
            "maxFlow = {$section->maxFlow}, " .
            "midFlow = {$section->midFlow}, " .
            "minFlow = {$section->minFlow}, " .
            "maxLevel = {$section->maxLevel}, " .
            "midLevel = {$section->midLevel}, " .
            "minLevel = {$section->minLevel} " .
            " where id = {$sectionId}";

        $this->connection->query($query);
        $this->connection->commit();
        return $section;
    }

    public function delete($sectionId)
    {
        if ($this->connection == null) {
            return "Database not connected";
        }

        $this->connection->query("delete from sections where id = $sectionId");
    }

}
