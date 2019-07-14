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
        $query = sprintf("select l.id from levelSpots l left outer join rivers r on l.river = r.id where r.name like '%s' and l.name like '%s'", trim($riverName), trim($levelSpotName));
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

        $query = sprintf('insert into levelSpots (name, origin, river) values ("%s", "REST added", %s)',
            trim($levelSpotName),
            trim($riverId));

        $this->connection->query($query);
        $reader = $this->connection->query("SELECT LAST_INSERT_ID()");

        $spotId = false;
        if ($reader === false or $this->connection->errno != 0)
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
        $timeStamp = $measurement->timeStamp;

        $query = "select * from levelSpots where id = {$levelSpotId} and lastMeasurement = '{$timeStamp}'";
        $reader = $this->connection->query($query);
        $found = false;
        if ($reader->fetch_row()) {
            $found = true;
        }
        $reader->close();

        if ($found) return false;


        $query = "update levelSpots set lastMeasurement = '{$timeStamp}', flow  = {$measurement->flow}, " .
            "level = {$measurement->level}, temperature = {$measurement->temperature} " .
            "where id = {$levelSpotId}";

        $this->connection->query($query);

        $query = "insert into measurements (levelSpot, timeStamp, level, flow, temperature) values" .
            "({$levelSpotId}, '{$timeStamp}', {$measurement->level}, {$measurement->flow}, {$measurement->temperature})";

        $this->connection->query($query);
        $this->connection->commit();

        return true;
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

    public function getForRiver($river)
    {
        $query = sprintf("select * from levelSpots where river = %s", $river);
        $rows = $this->connection->query($query);
        $result = [];
        while ($row = $rows->fetch_assoc()) {
            array_push($result, LevelSpot::fromJson($row));
        }
        return $result;
    }
}
