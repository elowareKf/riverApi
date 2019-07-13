<?php


class River
{

    public $sections;
    public $levelSpots;

    public static function getFromRow(array $row)
    {
        $result = new River();
        $result->id = trim($row['id']);
        $result->name = trim($row['name']);
        $result->countries = trim($row['countries']);
        $result->grades = trim($row['grades']);
        return $result;
    }
}
