<?php


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
        $this->connection = mysqli_connect($this->server, $this->user, $this->password, $this->database, $this->port);
    }

    public function getSection(int $id)
    {
        $query = `select *
        from sections s
        left outer join river r on r.id = s.river
        left outer join levelSpots l on l.id = s.levelSpot
        where id = $id `;

        $rows = $this->connection->fetchRow($query);

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
