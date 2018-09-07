<?php
namespace Medal\Model;

class Manufacturer extends ModelBase
{
    public $ID, $Name, $Wikipedia;
    
    public function getSource()
    {
        return 'au_manufacturer';
    }
}