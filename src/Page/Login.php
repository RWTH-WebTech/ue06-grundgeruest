<?php
namespace Application\Page;

use Application\Data\UserInterface;
use Application\Session;

class Login implements ProtectedPageInterface{
    protected $sessionManager;

    function __construct(Session $sessionManager)
    {
        $this->sessionManager = $sessionManager;
    }

    public function getTitle()
    {
        return 'Login';
    }

    public function getViewScript()
    {
        return __DIR__.'/../../view/login.phtml';
    }

    /**
     * Versucht, Login auszuführen, wenn Formular abgesendet
     * @return array
     */
    public function getViewVariables()
    {
        $isLoggedIn = $this->sessionManager->getCurrentUser() != null;
        if(!$isLoggedIn && !empty($_POST['name'])){
            $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
            $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
            $this->sessionManager->login($name, $password);
        }
        $currentUser = $this->sessionManager->getCurrentUser();
        $isLoggedIn = $currentUser != null;
        return ['isLoggedIn' => $isLoggedIn, 'currentUser' => $currentUser];
    }

    public function accessAllowed(UserInterface $user = null)
    {
        return $user === null;
    }
}