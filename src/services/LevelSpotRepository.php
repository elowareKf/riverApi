<?php


class LevelSpotRepository
{
    private $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    public function find($riverName, $levelSpotName)
    {
        $query = sprintf("select l.id from levelSpots l left outer join rivers r on l.river = r.id where r.name like '%s' and l.name like '%s'", $riverName, $levelSpotName);
        $rows = $this->connection->query($query);
        $result = false;

        if ($row = $rows->fetch_row()) {
            $result = $row[0];
        }

        $rows->close();

        return $result;
    }

    public function add($riverId, $levelSpotName)
    {
        if ($this->connection == null) {
            return "Database not connected";
        }

        $query = sprintf('insert into paddle_center.levelSpots (name, origin, river) values ("%s", "REST added", %i)',
            $levelSpotName,
            $riverId);

        $this->connection->query($query);
        $reader = $this->connection->query("SELECT LAST_INSERT_ID()");

        $spotId = false;
        if ($reader === false)
            die($this->connection->error . " Adding not successful");

        if ($row = $reader->fetch_row()) {
            $spotId = $row[0];
        }
        $reader->close();
        $this->connection->commit();
        return $spotId;
    }

    public function addMeasurement($levelSpotId, Measurement $measurement)
    {

    }

    public function get($id)
    {
        $query = "select * from levelSpots where id = $id";

        $rows = $this->connection->query($query);
        $result = null;
        while ($row = $rows->fetch_assoc()) {
            $result = LevelSpot::fromJson($row);
            $result->id = $id;
        }
        $rows->close();

        return $result;
    }
}
