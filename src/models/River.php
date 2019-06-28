<?php


class River
{
    public $id;
    public $name;
    public $countries;
    public $grades;
    public $sections;

    public static function getFromRow(array $row)
    {
        $result = new River();
        $result->id = $row['id'];
        $result->name = $row['name'];
        $result->countries = $row['countries'];
        $result->grades = $row['grades'];
        return $result;
    }
}
