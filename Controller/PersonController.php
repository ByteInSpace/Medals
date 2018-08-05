<?php
namespace Medal\Controller;

use Medal\Model\Person;
use RuntimeException;

abstract class PersonController implements Controller
{
    /** @var \Medal\Library\View */
    protected $view;
    public function setView(\Medal\Library\View $view)
    {
        $this->view = $view;
    }
    
    abstract public function showAllAction();
      
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