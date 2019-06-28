<?php


class Section
{
    public $id;
    public $name;
    public $country;
    public $grade;
    public $spotGrade;
    public $putIn;
    public $takeOut;
    public $parkPutIn;
    public $parkTakeOut;
    public $hotSpots;
    public $type;
    public $riverId;
    public $origin;
    public $extLevelSpot;
    public $extLevelType;
    public $minFlow;
    public $midFlow;
    public $maxFlow;
    public $minLevel;
    public $midLevel;
    public $maxLevel;
    public $levelSpotId;


    /**
     * @param $row
     * @return Section
     *
     * @inheritDoc look at the definition of the methode to provide right column names
     *  !! Change this line after release with the actual documentation !!
     */
    static function getSectionFromRow($row)
    {
        $section = new Section();
        $section->grade = $row['general_grade'];
        $section->name = $row['section'];
        $section->country = $row['country'];
        $section->spotGrade = $row['spot_grades'];
        $section->id = $row['sectionId'];
        $section->putIn = $row['latstart'] . ';' . $row['lngstart'];
        $section->takeOut = $row['latend'] . ';' . $row['lngend'];
        $section->type = $row['type'];
        $section->riverId = $row['riverId'];
        $section->origin = $row['sectionOrigin'];
        $section->extLevelSpot = $row['extLevelSpot'];
        $section->extLevelType = $row['extLevelType'];
        $section->minFlow = $row['minFlow'];
        $section->midFlow = $row['midFlow'];
        $section->maxFlow = $row['maxFlow'];
        $section->minLevel = $row['minLevel'];
        $section->midLevel = $row['midLevel'];
        $section->maxLevel = $row['maxLevel'];
        $section->levelSpotId = $row['levelSpot'];

        return $section;
    }

    static function getFromJson($json)
    {
        $section = new Section();
        $section->id = $json['id'];
        $section->grade = $json['grade'];
        $section->name = $json['name'];
        $section->country = $json['country'];
        $section->spotGrade = $json['spotGrade'];
        $section->id = $json['id'];
        $section->putIn = $json['putIn'];
        $section->takeOut = $json['takeOut'];
        $section->type = $json['type'];
        $section->riverId = $json['riverId'];
        $section->origin = $json['origin'];
        $section->extLevelSpot = $json['extLevelSpot'];
        $section->extLevelType = $json['extLevelType'];
        $section->minFlow = $json['minFlow'] ?? 'null';
        $section->midFlow = $json['midFlow'] ?? 'null';
        $section->maxFlow = $json['maxFlow'] ?? 'null';
        $section->minLevel = $json['minLevel'] ?? 'null';
        $section->midLevel = $json['midLevel'] ?? 'null';
        $section->maxLevel = $json['maxLevel'] ?? 'null';
        $section->levelSpotId = $json['levelSpotId'] ?? 'null';

        return $section;
    }

}
