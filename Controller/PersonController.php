<?php
namespace Medal\Controller;

use Medal\Library\NotFoundException;
use Medal\Model\Person;
use RuntimeException;

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
      
    public function editAction()
    {
        echo "Edit";
        $url      = (isset($_GET['_url']) ? $_GET['_url'] : '');
        $urlParts = explode('/', $url);
        echo "gefunden: $urlParts[2]";
    }
    
    public function deleteAction()
    {
        try {
            $id = $this->getID();
            Person::delete($id);
            $this->view->setVars(['deleted' => 'Successfully deleted']);
        }
        catch (RuntimeException $e) {
            $this->view->setVars([
                'deleted' => 'Unable to delete',
            ]);
        }
            
            
        
    }
    
    private function getID()
    {
        $url      = (isset($_GET['_url']) ? $_GET['_url'] : '');
        $urlParts = explode('/', $url);
        return $urlParts[2];
    }
    
}