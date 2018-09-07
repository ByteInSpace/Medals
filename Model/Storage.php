<?php
namespace Medal\Model;

class Storage extends ModelBase
{
    public $ID, $Name, $ManufacturerID, $Deleted;
    
    public function getSource()
    {
        return 'au_storage';
    }
}