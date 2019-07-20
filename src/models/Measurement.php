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
        $result->level = trim($measurement['level']);
        $result->flow = trim($measurement['flow']);
        $result->temperature = trim($measurement['temperature']);
        $result->timeStamp = trim($measurement['timestamp']);
        if ($result->timeStamp == "")
            $result->timeStamp = trim($measurement['timeStamp']);
        # $result->timeStamp = DateTime::createFromFormat('Y-m-d H:i:s' ,$measurement['timestamp']);
        return $result;
    }
}


