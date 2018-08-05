<?php
namespace Medal\Controller;

use Medal\Model\Person;

class AutorController extends PersonController
{
    public function showAllAction()
    {
        
        $persons = Person::findAll('Autor=1');
        $this->view->setArray($persons, "PERSON");
        
    }
}