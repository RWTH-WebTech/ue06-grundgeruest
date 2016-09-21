<?php
namespace Application\Page;

/**
 * Grundlegendes Seiten-Interface
 * @package Application\Page
 */
interface PageInterface{

    /**
     * Gibt den Seitentitel zurück
     * @return string
     */
    public function getTitle();

    /**
     * Gibt den Pfad zum ViewScript der Seite an
     * @return string
     */
    public function getViewScript();

    /**
     * Gibt ein Array mit den View Variablen zurück, welches an das ViewScript übergeben werden soll.
     * @return array
     */
    public function getViewVariables();

}