<?php
namespace Medal\Controller;

use Medal\Library\NotFoundException;
use Medal\Model\Person;

class PersonController implements Controller
{
    /** @var \Medal\Library\View */
    protected $view;
    public function setView(\Medal\Library\View $view)
    {
        $this->view = $view;
    }
    
    public function showAllAction()
    {
        $persons = Person::findAll();
        $this->view->setArray($persons, "PERSON");
        
    }
    
}