<?php

namespace Medal\Controller;

use Medal\Model\Land;
use Medal\Model\Seller;
use RuntimeException;

class SellerController implements Controller
{
    /** @var \Medal\Library\View */
    protected $view;
    public function setView(\Medal\Library\View $view)
    {
        $this->view = $view;
    }
    
    public function showAllAction()
    {
        
        $sellers = Seller::findAll('');
        $this->view->setArray($sellers, "SELLER");
        
    }
    
    public function editAction()
    {
        $id = intval($_GET['ID']);
        $seller = Seller::findFirst($id);
        $land = Land::findAll('');
        $this->view->setArray($land, "LAND");
        $this->view->setVars([
            'SELLER' => $seller,
        ]);
        
    }
    
    public function deleteAction()
    {
        try {
            $id = $this->getID();
            Seller::delete($id);
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
        $seller = new Seller();
        $seller->ID = $_GET['ID'];
        $seller->Name = $_GET['name'];
        $seller->LandID = $_GET['landID'];
        $seller->Street = $_GET['street'];
        $seller->Number = $_GET['number'];
        $seller->Zip = $_GET['zip'];
        $seller->City = $_GET['city'];
        $seller->Favourite = $_GET['favourite'];
        $seller->Auction = (empty($_GET['auction']) ? '0' : '1');
        $seller->Private = (empty($_GET['private']) ? '0' : '1');
        $seller->Shop = (empty($_GET['shop']) ? '0' : '1');
        $seller->Phone = $_GET['phone'];
        $seller->Email = $_GET['Email'];
        $seller->Homepage = $_GET['homepage'];
        $seller->Deleted = '0';
        return $seller;
    }
    
    public function editDoneAction()
    {
        $seller = $this->mapRequestToObject();
        
        try
        {
            $seller->save();
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
        $seller = $this->mapRequestToObject();
        
        //         var_dump($person);
        try
        {
            $seller->save();
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
