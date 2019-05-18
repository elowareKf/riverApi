<?php


class Section{
    public $id;
    public $name;
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


    /**
     * @param $row
     * @return Section
     *
     * @inheritDoc look at the definition of the methode to provide right column names
     *  !! Change this line after release with the actual documentation !!
     */
    static function getSectionFromRow($row){
        $section = new Section();
        $section->grade = $row['general_grade'];
        $section->name = $row['section'];
        $section->spotGrade = $row['spot_grades'];
        $section->id = $row['sectionId'];
        $section->putIn = $row['latstart'].';'.$row['lngstart'];
        $section->takeOut = $row['latend'].';'.$row['lngend'];
        $section->type = $row['type'];
        $section->riverId = $row['riverId'];
        $section->origin = $row['sectionOrigin'];
        return $section;
    }

}
