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

        $result->apiUrl = trim($json['apiUrl']);
        $result->name = trim($json['name']);
        $result->creekKm = trim($json['creekKm']);
        $result->latLng = trim($json['latLng']);
        $result->lastMeasurement = trim($json['lastMeasurement']);
        $result->flow = trim($json['flow']);
        $result->level = trim($json['level']);
        $result->temperature = trim($json['temperature']);

        return $result;
    }
}

