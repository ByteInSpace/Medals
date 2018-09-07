<?php
namespace Medal\Controller;

use Medal\Model\Manufacturer;
use Medal\Model\Storage;
use RuntimeException;

class StorageController implements Controller
{
    /** @var \Medal\Library\View */
    protected $view;
    public function setView(\Medal\Library\View $view)
    {
        $this->view = $view;
    }
    
    public function showAllAction()
    {
        
        $storage = Storage::findAll('');
        $this->view->setArray($storage, "STORAGE");
        
        $manufacturer = Manufacturer::findAll('');
        $this->view->setArray($manufacturer, "MANUFACTURER");
        
    }
      
    public function editAction()
    {
        //$id = intval($_GET['ID']);
        $id = intval($this->getID());
        $storage = Storage::findFirst($id);
        $manufacturer = Manufacturer::findAll('');
        $this->view->setArray($manufacturer, "MANUFACTURER");
        $this->view->setVars([
            'STORAGE' => $storage,
        ]);
        
    }
    
    public function deleteAction()
    {
        try {
            $id = $this->getID();
            Storage::delete($id);
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
        $manufacturer = Manufacturer::findAll('');
        $this->view->setArray($manufacturer, "MANUFACTURER");
    }
    
   
    
    private function mapRequestToObject()
    {
        $storage = new Storage();
        $storage->ID = $_POST['ID'];
        $storage->Name = $_POST['name'];
        $storage->ManufacturerID = $_POST['manufacturerID'];
        $storage->Deleted = '0';
        return $storage;
    }
    
    public function editDoneAction()
    {
        $storage = $this->mapRequestToObject();
        try
        {
            $storage->save();
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
        $storage = $this->mapRequestToObject();
        
//         var_dump($person);
        try 
        {
            $storage->save();
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