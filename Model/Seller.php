<?php
namespace Medal\Model;

class Seller extends ModelBase
{
    public $ID, $Name, $LandID, $Street, $Number, $Zip, $City, $Favourite, $Auction, $Private, $Shop, $Phone, $Email, $Homepage, $Deleted;
    
    public function getSource()
    {
        return 'md_seller';
    }
}