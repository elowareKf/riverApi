<?php


class Measurement
{
    public $levelSpotId;
    public $timeStamp;
    public $level;
    public $flow;
    public $temperature;
    public $origin;

    public static function fromJson($measurement)
    {
        $result = new Measurement();

        if (trim($measurement['level']) == "")
            $result->level = null;
        else
            $result->level = trim($measurement['level']);


        if (trim($measurement['flow']) == "")
            $result->flow = null;
        else
            $result->flow = trim($measurement['flow']);

        if (trim($measurement['temperature']) == "")
            $result->temperature = null;
        else
            $result->temperature = trim($measurement['temperature']);


        $result->timeStamp = trim($measurement['timestamp']);
        if ($result->timeStamp == "")
            $result->timeStamp = trim($measurement['timeStamp']);
        # $result->timeStamp = DateTime::createFromFormat('Y-m-d H:i:s' ,$measurement['timestamp']);

        $result->origin = "data";
        return $result;
    }
}


