<?php


class Measurement
{
    public $levelSpotId;
    public $timeStamp;
    public $level;
    public $flow;
    public $temperature;

    public static function fromJson($measurement)
    {
        $result = new Measurement();
        $result->level = $measurement['level'];
        $result->flow = $measurement['flow'];
        $result->temperature = $measurement['temperature'];
        # $result->timeStamp = DateTime::createFromFormat('Y-m-d H:i:s' ,$measurement['timestamp']);
        $result->timeStamp = $measurement['timestamp'];
        return $result;
    }
}


