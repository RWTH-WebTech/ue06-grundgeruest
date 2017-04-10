<?php
namespace Application;

use Application\Data\UserInterface;
use Application\Data\UserDataInterface;

/**
 * Session Management Klasse
 * @package Application
 */
class Session {

    /** @var  UserDataInterface */
    protected $data;
    /** @var  UserInterface */
    protected $currentUser = null;

    const USER_ID_KEY = 'userId';

    /**
     * @return UserDataInterface
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return UserInterface
     */
    public function getCurrentUser()
    {
        return $this->currentUser;
    }

    /**
     * Startet Session und initialisiert lokale Veriablen
     * @param UserDataInterface $data
     */
    public function __construct(UserDataInterface $data){
        $this->data = $data;
        session_start();
        if(!empty($_SESSION[self::USER_ID_KEY])){
            $this->currentUser = $this->getData()->getUser($_SESSION[self::USER_ID_KEY]);
        }
    }

    /**
     * Versucht den Benutzer mit übergebenem Namen und Passwort einzuloggen. Gibt true im Erfolgsfall zurück und false
     * sonst.
     * @param string $name
     * @param string $password
     * @return bool
     */
    public function login($name, $password){
        $user = $this->getData()->getUserByName($name);
        if(!$user){
            return false;
        }
        if(!password_verify($password, $user->getPassword())){
            return false;
        }
        if(!$this->loginAllowed($user)){
            return false;
        }
        $_SESSION[self::USER_ID_KEY] = $user->getId();
        $this->currentUser = $user;
        return true;
    }

    /**
     * Loggt den Benutzer aus und zerstört die Session.
     */
    public function logout(){
        $_SESSION[self::USER_ID_KEY] = null;
        $this->currentUser = null;
        session_destroy();
    }


    /**
     * Gibt true zurück, wenn der Benutzer sich einloggen darf
     * @param UserInterface $user
     * @return bool
     */
    public function loginAllowed(UserInterface $user){
        return true;
    }
}