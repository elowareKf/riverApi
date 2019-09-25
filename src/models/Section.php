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
    public $riverName;

    public $levelSpot;

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
        $section->riverName = $row['riverName'];

        return $section;
    }

    static function getFromJson($json)
    {
        if ($json['minLevel'] == '') $json['minLevel'] = 'null';
        if ($json['midLevel'] == '') $json['midLevel'] = 'null';
        if ($json['maxLevel'] == '') $json['maxLevel'] = 'null';
        if ($json['minFlow'] == '') $json['minFlow'] = 'null';
        if ($json['midFlow'] == '') $json['midFlow'] = 'null';
        if ($json['maxFlow'] == '') $json['maxFlow'] = 'null';


        $section = new Section();
        $section->id = $json['id'];
        $section->grade = trim($json['grade']);
        $section->name = trim($json['name']);
        $section->country = trim($json['country']);
        $section->spotGrade = trim($json['spotGrade']);
        $section->id = trim($json['id']);
        $section->putIn = trim($json['putIn']);
        $section->takeOut = trim($json['takeOut']);
        $section->type = trim($json['type']);
        $section->riverId = trim($json['riverId']);
        $section->origin = trim($json['origin']);
        $section->extLevelSpot = trim($json['extLevelSpot']);
        $section->extLevelType = trim($json['extLevelType']);
        $section->minFlow = trim($json['minFlow'] ?? 'null');
        $section->midFlow = trim($json['midFlow'] ?? 'null');
        $section->maxFlow = trim($json['maxFlow'] ?? 'null');
        $section->minLevel = trim($json['minLevel'] ?? 'null');
        $section->midLevel = trim($json['midLevel'] ?? 'null');
        $section->maxLevel = trim($json['maxLevel'] ?? 'null');
        $section->levelSpotId = trim($json['levelSpotId'] ?? 'null');
        $section->riverName = $json['riverName'];

        return $section;
    }

}
