<?php

class DataLinearizer
{

    private $data;

    public function __construct(array $values)
    {
        $this->data = $values;
    }

    public function linearizeData(): array
    {
        $minDiff = $this->getSmallestTimeDifference();
        $this->addSpareDataSets($minDiff);
        usort($this->data, function ($measurement1, $measurement2) {
            if (self::getDateTime($measurement1->timeStamp) == self::getDateTime($measurement2->timeStamp))
                return 0;

            return self::getDateTime($measurement1->timeStamp) > self::getDateTime($measurement2->timeStamp) ? 1 : -1;
        });
        return $this->data;
    }


    private function addSpareDataSets($interval)
    {
        $lastTimeStamp = null;
        foreach ($this->data as $value) {
            if ($lastTimeStamp == null) {
                $lastTimeStamp = self::getDateTime($value->timeStamp);
                continue;
            }

            $currentTime = self::getDateTime($value->timeStamp);

            if (self::getTotalMinutes($lastTimeStamp->diff($currentTime)) == $interval) {
                $lastTimeStamp = $currentTime;
                continue;
            }

            do {
                $inserter = $lastTimeStamp->add(new DateInterval("PT15M"));
                if ($inserter >= $currentTime) break;

                $measrement = new Measurement();
                $measrement->levelSpotId = $value->levelSpotId;
                $measrement->origin = "spare";
                $measrement->timeStamp = $inserter->format('Y-m-d H:i:s');
                error_log($measrement->timeStamp);
                array_push($this->data, $measrement);
            } while ($inserter < $currentTime);

            $lastTimeStamp = $currentTime;

        }
    }

    private function getSmallestTimeDifference()
    {
        $difference = 1440;
        $lastValue = new DateTime('2000-01-01');
        foreach ($this->data as $value) {
            $current = self::getDateTime($value->timeStamp);


            $temp = self::getTotalMinutes($current->diff($lastValue));
            // error_log($current->format("Y-m-d H:i:s") . " - " . $lastValue->format("Y-m-d H:i:s") . " = " . $temp);
            if ($temp < $difference && $temp != 0)
                $difference = $temp;

            $lastValue = new DateTime($current->format("Y-m-d H:i:s"));
        }
        return $difference;
    }

    public static function getDateTime($value): DateTime
    {
        $result = new DateTime($value);
        error_log($result);
        return $result;
    }

    public static function getTotalMinutes(DateInterval $int)
    {
        return ($int->d * 24 * 60) + ($int->h * 60) + $int->i;
    }

}
