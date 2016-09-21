<?php
namespace Application\Page;

use Application\Data\UserInterface;

interface ProtectedPageInterface extends PageInterface {
    /**
     * Gibt true zurück, wenn der übergebene Benutzer auf die Seite zugreifen darf, sonst false. Ist kein Benutzer
     * eingeloggt, wird null als parameter übergeben.
     * @param UserInterface $user
     * @return boolean
     */
    public function accessAllowed(UserInterface $user = null);
}