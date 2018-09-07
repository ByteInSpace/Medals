<?php
namespace Medal\Controller;

use Medal\Model\Manufacturer;
use Medal\Model\Serie;
use RuntimeException;

class SerieController implements Controller
{
    /** @var \Medal\Library\View */
    protected $view;
    public function setView(\Medal\Library\View $view)
    {
        $this->view = $view;
    }
    
    public function showAllAction()
    {
        
        $serie = Serie::findAll('');
        $this->view->setArray($serie, "SERIE");
        
        $manufacturer = Manufacturer::findAll('');
        $this->view->setArray($manufacturer, "MANUFACTURER");
        
    }
    
    public function editAction()
    {
        //$id = intval($_GET['ID']);
        $id = intval($this->getID());
        $serie = Serie::findFirst($id);
        $manufacturer = Manufacturer::findAll('');
        $this->view->setArray($manufacturer, "MANUFACTURER");
        $this->view->setVars([
            'SERIE' => $serie,
        ]);
        
    }
    
    public function deleteAction()
    {
        try {
            $id = $this->getID();
            Serie::delete($id);
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
        $serie = new Serie();
        $serie->ID = $_POST['ID'];
        $serie->Name = $_POST['name'];
        $serie->ManufacturerID = $_POST['manufacturerID'];
        $serie->MaximalAmount = $_POST['maximalAmount'];
        $serie->Deleted = '0';
        return $serie;
    }
    
    public function editDoneAction()
    {
        $serie = $this->mapRequestToObject();
        try
        {
            $serie->save();
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
        $serie = $this->mapRequestToObject();
        
        //         var_dump($person);
        try
        {
            $serie->save();
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