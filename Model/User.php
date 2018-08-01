<?php
namespace Medal\Model;

class User extends ModelBase
{
    public $id, $name, $created;
    public function getSource()
    {
        return 'users';
    }
}