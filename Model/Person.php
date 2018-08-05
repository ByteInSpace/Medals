<?php
namespace Medal\Model;

class Person extends ModelBase
{
    public $ID, $Name, $Vorname, $NationID, $Curriculum_DEU, $Curriculum_PL, $Image, $Image_Copyright, $Wikipedia, $Medaleur, $Autor;
    
    public function getSource()
    {
        return 'md_person';
    }
}