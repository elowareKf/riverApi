<?php


class RiverRepository
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
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

    public function get($id)
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

    public function add($riverName)
    {
        if ($this->connection == null) {
            return "Database not connected";
        }

        $query = "insert into rivers (name) values ('$riverName')";
        echo $query;
    }

    public function find($search)
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

    public function update($riverId, River $river)
    {
        if ($this->connection == null) {
            return "Database not connected";
        }

        $query = "update rivers set name = '{$river->name}', countries = '{$river->countries}', grades = '{$river->grades}' where id = {$riverId}";
        $this->connection->query($query);
    }


    public function delete($riverId){
        if ($this->connection == null) {
            return "Database not connected";
        }

        $query = "delete from rivers where id = {$riverId}";
        $this->connection->query($query);
    }
}
