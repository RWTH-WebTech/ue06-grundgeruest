<?php
namespace Application;

use Application\Page\PageInterface;

/**
 * Objektmodell der Webanwendung. Verwaltet die Seiten und die Navigation.
 * @package Application
 */
class Application{

    const PAGE_PARAMETER = 'page';

    /** @var Renderer  */
    protected $renderer;
    /** @var Session */
    protected $sessionManager;
	/** @var PageInterface[] */
    protected $pages;
	/** @var NavigationItem[] */
    protected $navigation;

    /**
     * @param PageInterface[] $pages
     * @param NavigationItem[] $navigation
     */
    public function __construct($pages = [], $navigation = [])
    {
        $this->renderer = new Renderer();
        $this->pages = $pages;
        $this->navigation = $navigation;
    }

    /**
     * Fügt neue Seite mit angegebener Id hinzu. Existert die Id bereits, wird die gespeicherte Seite überschrieben
     * @param string $id Id der Seite
     * @param PageInterface $page Seitenklasse
     */
    public function addPage($id, PageInterface $page)
    {
        $this->pages[$id] = $page;
    }

    /**
     * Fügt einen Navigationspunkt am Ende hinzu
     * @param NavigationItem $item
     */
    public function addNavigationItem(NavigationItem $item)
    {
        $this->navigation[] = $item;
    }

    /**
     * Gibt den Session Manager zurück
     * @return Session
     */
    public function getSessionManager(){
        if(!$this->sessionManager){
            throw new \Exception('Session Manager nicht gesetzt');
        }
        return $this->sessionManager;
    }

    /**
     * Führt das Programm aus
     */
    public function run(){
        $pageId = $this->getStandardPageId();
        if(
            isset($_GET[self::PAGE_PARAMETER]) &&
            $this->accessAllowed($_GET[self::PAGE_PARAMETER])
        ){
            $pageId = $_GET[self::PAGE_PARAMETER];
        }
        $variables = $this->getPageVariables($pageId);
        $this->renderer->showViewScript($this->getLayoutViewScript(), $variables);
    }

    /**
     * Gibt zurück, ob der Zugriff auf die übergebene Seiten-ID für den aktuellen Benutzer erlaubt ist.
     * @param string $pageId
     * @return bool
     */
    protected function accessAllowed($pageId){
        if($pageId === null){
            return false;
        }
        if(!isset($this->pages[$pageId])){
            return false;
        }
        if(!($this->pages[$pageId] instanceof ProtectedPageInterface)){
            return true;
        }
        return $this->pages[$pageId]->accessAllowed($this->getSessionManager()->getCurrentUser());
    }

    /**
     * Gibt die ID der Seite zurück, die standardmäßig angezeigt werden soll
     * @return string|null
     */
    protected function getStandardPageId(){
        foreach(array_keys($this->pages) as $id){
            if($this->accessAllowed($id)){
                return $id;
                break;
            }
        }
        return null;
    }

    /**
     * Gibt die Seitenvariablen zurück
     * @return array
     */
    protected function getPageVariables($pageId){
        if(!$this->accessAllowed($pageId)){
            return [ 'pageTitle' => '404 - Page not found', 'pageContent' => '<h1>404 - Page not found</h1>',
                'activePageId' => null, 'navigation' => [] ];
        }
        $page = $this->pages[$pageId];
        $content = $this->renderer->render($page);
        $title = $page->getTitle();
        $navigation = [];
        foreach($this->navigation as $navItem){
            if($this->accessAllowed($navItem->getPageId())){
                $navigation[] = $navItem;
            }
        }
        return [ 'pageTitle' => $title, 'pageContent' => $content,
            'activePageId' => $pageId, 'navigation' => $navigation ];
    }


    /**
     * Gibt das ViewScript für das layout zurück
     * @return string
     */
    public function getLayoutViewScript()
    {
        return __DIR__.'/../../../../view/layout.phtml';
    }
}