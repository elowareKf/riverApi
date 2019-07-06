<?php


class LevelSpot{
    public $id;
    public $apiUrl;
    public $name;
    public $creekKm;
    public $latLng;
    public $lastMeasurement;
    public $flow;
    public $level;
    public $temperature;

    public static function fromJson($json){
        $result = new LevelSpot();

        $result->apiUrl = $json['apiUrl'];
        $result->name = $json['name'];
        $result->creekKm = $json['creekKm'];
        $result->latLng = $json['latLng'];
        $result->lastMeasurement = $json['lastMeasurement'];
        $result->flow = $json['flow'];
        $result->level = $json['level'];
        $result->temperature = $json['temperature'];

        return $result;
    }
}

