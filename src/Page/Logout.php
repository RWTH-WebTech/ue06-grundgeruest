<?php
namespace Application\Page;

use Application\Data\UserInterface;
use Application\Session;

class Logout implements ProtectedPageInterface{
    protected $sessionManager;

    function __construct(Session $sessionManager)
    {
        $this->sessionManager = $sessionManager;
    }

    public function getTitle()
    {
        return 'Logout';
    }

    public function getViewScript()
    {
        return __DIR__.'/../../view/logout.phtml';
    }

    /**
     * Führt logout duch
     * @return array
     */
    public function getViewVariables()
    {
        $this->sessionManager->logout();
        return [];
    }

    public function accessAllowed(UserInterface $flatMate = null)
    {
        return $flatMate !== null;
    }
}