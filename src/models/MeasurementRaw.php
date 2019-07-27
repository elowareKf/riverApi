<?php


class MeasurementRaw
{
    public $levelSpotName;
    public $riverName;
    public $timeStamp;
    public $level;
    public $flow;
    public $temperature;

    public static function fromJson($dataSetRaw)
    {
        $result = new MeasurementRaw();

        $result->levelSpotName = $dataSetRaw['levelSpotName'];
        $result->riverName = $dataSetRaw['riverName'];
        $result->timeStamp = $dataSetRaw['timeStamp'];
        $result->level = $dataSetRaw['level'];
        $result->flow = $dataSetRaw['flow'];
        $result->temperature = $dataSetRaw['temperature'];

        return $result;
    }

    public function getMeasurement($levelSpotId){
        $result = new Measurement();

        $result->flow = $this->flow ?? 'null';
        $result->level = $this->level ?? 'null';
        $result->levelSpotId = $levelSpotId;
        $result->temperature = $this->temperature ?? 'null';
        $result->timeStamp = $this->timeStamp;

        return $result;
    }
}
