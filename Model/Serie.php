<?php
namespace Medal\Model;

class Serie extends ModelBase
{
    public $ID, $Name, $ManufacturerID, $MaximalAmount, $Deleted;
    
    public function getSource()
    {
        return 'au_serie';
    }
}