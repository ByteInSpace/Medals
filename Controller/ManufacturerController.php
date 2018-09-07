<?php
namespace Medal\Controller;

use Medal\Model\Land;
use Medal\Model\Manufacturer;
use RuntimeException;

class ManufacturerController implements Controller
{
    /** @var \Medal\Library\View */
    protected $view;
    public function setView(\Medal\Library\View $view)
    {
        $this->view = $view;
    }
    
    public function showAllAction()
    {
        
        $persons = Manufacturer::findAll('');
        $this->view->setArray($persons, "MANUFACTURER");
        
    }
      
    public function editAction()
    {
        $manufacturer = Manufacturer::findFirst(intval($id));
        $this->view->setVars([
            'MANUFACTURER' => $manufacturer,
        ]);
        
    }
    
    public function deleteAction()
    {
        try {
            $id = $this->getID();
            Manufacturer::delete($id);
            $this->view->setVars(['deleted' => 'Successfully deleted']);
        }
        catch (RuntimeException $e) {
            $this->view->setVars([
                'deleted' => 'Unable to delete',
            ]);
        }
    }
    
    public function addNewAction()
    {
        $land = Land::findAll('');
        $this->view->setArray($land, "LAND");
    }
    
   
    
    private function mapRequestToObject()
    {
        $manufacturer = new Manufacturer();
        $manufacturer->ID = $_POST['ID'];
        $manufacturer->Name = $_POST['name'];
        $manufacturer->Wikipedia = $_POST['wikipedia'];
        $manufacturer->Deleted = '0';
        return $manufacturer;
    }
    
    public function editDoneAction()
    {
        $manufacturer = $this->mapRequestToObject();
        
        try
        {
            $manufacturer->save();
            $this->view->setVars([
                'updated' => "Successfull",
            ]);
        }
        catch (RuntimeException $e) {
            $errorMessage = $e->getMessage();
            $this->view->setVars([
                'updated' => $errorMessage,
            ]);
        }
    }
    
    public function addNewDoneAction()
    {
        $manufacturer = $this->mapRequestToObject();
        
//         var_dump($person);
        try 
        {
            $manufacturer->save();
        }
        catch (RuntimeException $e) {
            $errorMessage = $e->getMessage();
            $this->view->setVars([
                'added' => $errorMessage,
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