<?php
namespace Application\Data;

interface UserDataInterface {

    /**
     * Sucht nach dem übergebenen Namen und gibt den passenden Benutzer zurück. Wenn kein Benutzer mit dem
     * Namen gefunden, wird null zurückgegeben.
     * @param string $name
     * @return UserInterface|null
     */
    public function getUserByName($name);

    /**
     * Sucht nach der übergebenen ID und gibt den passenden Benutzer zurück. Wenn kein Benutzer mit der ID
     * gefunden, wird null zurückgegeben.
     * @param int $id
     * @return UserInterface|null
     */
    public function getUser($id);
}