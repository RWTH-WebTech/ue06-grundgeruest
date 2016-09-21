<?php
namespace Application\Data;

interface UserInterface {

    /**
     * Gibt die eindeutige ID des Benutzers zurück
     * @return int
     */
    public function getId();

    /**
     * Gibt den eindeutigen Namen des Benutzers zurück
     * @return string
     */
    public function getName();

    /**
     * Gibt den Passwort Hash zurück
     * @return string
     */
    public function getPassword();
}