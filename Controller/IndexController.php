<?php
namespace Medal\Controller;

use Medal\Library\NotFoundException;
use Medal\Model\User;

class IndexController implements Controller
{
    /** @var \Medal\Library\View */
    protected $view;
    public function setView(\Medal\Library\View $view)
    {
        $this->view = $view;
    }
    public function indexAction()
    {
        $this->view->setVars([
            'name' => 'Daniel',
        ]);
    }
    
    public function showUserAction()
    {
        $uid = (int)(isset($_GET['uid']) ? $_GET['uid'] : '1');
        if (!$uid) {
            throw new NotFoundException();
        }
        $user = User::findFirst($uid);
        if (!$user instanceof User) {
            throw new NotFoundException();
        }
        $this->view->setVars(['name' => $user->name]);
    }
}