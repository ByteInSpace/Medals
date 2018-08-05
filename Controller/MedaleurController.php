<?php
namespace Medal\Controller;

use Medal\Model\Person;

class MedaleurController extends PersonController
{
    public function showAllAction()
    {
       
        $persons = Person::findAll('Medaleur=1');
        $this->view->setArray($persons, "PERSON");
        
    }
}