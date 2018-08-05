<?php
namespace Medal\Model;

class Land extends ModelBase
{
    public $ID, $Country_DEU, $Country_PL;
    
    public function getSource()
    {
        return 'md_land';
    }
}