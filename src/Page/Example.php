<?php
namespace Application\Page;

/**
 * Hello World Seite
 * @package Application\Page
 */
class Example implements PageInterface {
    /**
     * Gibt den Seitentitel zurück
     * @return string
     */
    public function getTitle()
    {
        return 'Hallo Welt';
    }

    /**
     * Gibt den Pfad zum ViewScript der Seite an
     * @return string
     */
    public function getViewScript()
    {
        return __DIR__.'/../../../view/example.phtml';
    }

    /**
     * Gibt ein Array mit den View Variablen zurück, welches an das ViewScript übergeben werden soll.
     * @return array
     */
    public function getViewVariables()
    {
        return ['name' => 'Alice'];
    }
}