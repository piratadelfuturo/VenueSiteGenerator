<?php
use Sulu\Component\DocumentManager\DocumentManager;
use Sulu\Bundle\DocumentManagerBundle\DataFixtures\DocumentFixtureInterface;
use Sulu\Component\Content\Document\WorkflowStage;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Sulu\Bundle\ContentBundle\Document\HomeDocument;

/**
 * Description of PmgFixture
 *
 * @author daniel
 */
class PmgFixture implements DocumentFixtureInterface, ContainerAwareInterface{
    
    private $container;
    
    private $documentManager;
    
    public function getLocales(){
        
        return ['en','fr'];
    }
    
    public function getOrder()
    {
        return 10;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    public function getContainer(){
        return $this->container;
    }
    
    public function load(DocumentManager $documentManager)
    {
        $locales = $this->getLocales();
        $homeDocuments = array();
        $webspaceManager = $this->container->get('sulu_core.webspace.webspace_manager');
        $this->documentManager = $documentManager;
        $webspaces = $webspaceManager->getWebspaceCollection();
        foreach($webspaces as $webspace){
            $webspaceKey = $webspace->getKey();
            $homeDocuments[$webspaceKey] = $this->populateHomeDocument(
                    $webspaceKey,
                    $locales
                    );
            $this->generateHallsDocuments(
                    $homeDocuments[$webspaceKey],
                    $webspaceKey,
                    $locales
                    );
            $this->generateMenusDocuments(
                    $homeDocuments[$webspaceKey],
                    $webspaceKey,
                    $locales
                    );

        }
        
    }
    
    /**
     * Create a webspace node with the given locales.
     *
     * @param string $name
     * @param string[] $locales
     */
    protected function populateHomeDocument($name, $locales)
    {
        $documentManager = $this->documentManager;
        $pathName = '/cmf/'.$name.'/contents';
        $homeDocument = $documentManager->find($pathName);
        $homeDocument->setTitle('Homepage');
        $homeDocument->setStructureType('homepage');
        $homeDocument->setWorkflowStage(WorkflowStage::PUBLISHED);
        $homeDocument->getStructure()->bind(
                array(
                    'title' => 'Homepage',
                    'slogan' => 'slogan',
                    'slogan_text' => 'slogan text'
            )
        );
        foreach($locales as $locale){
            $documentManager->persist(
                $homeDocument,
                $locale,
                [
                    'path' => $pathName,
                    'auto_create' => true,
                    'load_ghost_content' => false,
                ]
            );
            $documentManager->flush();
        }
        
        return $homeDocument;
    }
    
    protected function generateHallsDocuments($parentDocument, $webspaceKey, $locales) {
        $templateKey = 'halls';
        $documentManager = $this->documentManager;
        
        $page = $documentManager->create('page');
        foreach($locales as $locale){
            $page->setStructureType($templateKey);
            $page->setTitle('Our Halls');
            $page->setWorkflowStage(WorkflowStage::PUBLISHED);
            $resource = $this->generateRLAction(
                    $parentDocument->getUuid(),
                    $page->getUuid(),
                    array('title' => $page->getTitle()),
                    $templateKey,
                    $webspaceKey,
                    $locale
                    );
            $page->setResourceSegment($resource['resourceLocator']);
            $page->getStructure()->bind(array(
                'title' => $page->getTitle()
            ));
            $documentManager->persist($page, $locale, array(
                'parent_path' => $parentDocument->getPath()
            ));
            
            $documentManager->flush();
        }
        //load halls foreach webspace
    }
    
    protected function generateMenusDocuments($parentDocument, $webspaceKey, $locales) {
        $templateKey = 'menus';
        $documentManager = $this->documentManager;
        
        $page = $documentManager->create('page');
        foreach($locales as $locale){
            $page->setStructureType($templateKey);
            $page->setTitle('Our Menus');
            $page->setWorkflowStage(WorkflowStage::PUBLISHED);
            $resource = $this->generateRLAction(
                    $parentDocument->getUuid(),
                    $page->getUuid(),
                    array('title' => $page->getTitle()),
                    $templateKey,
                    $webspaceKey,
                    $locale
                    );
            $page->setResourceSegment($resource['resourceLocator']);
            $page->getStructure()->bind(array(
                'title' => $page->getTitle()
            ));
            $documentManager->persist($page, $locale, array(
                'parent_path' => $parentDocument->getPath()
            ));
            
            $documentManager->flush();
        }
        //load halls foreach webspace
    }
    
    protected function loadTestimonialPages(DocumentManager $documentManager){
        
        
    }
    
    protected function loadContactPages(){
        
        
        
    }
    
    
    protected function generateRLAction($parentUuid,$uuid,$parts = array('title' =>''),$templateKey,$webspaceKey,$languageCode)
    {
        if ($templateKey === null) {
            $webspaceManager = $this->container->get('sulu_core.webspace.webspace_manager');
            $webspace = $webspaceManager->findWebspaceByKey($webspaceKey);
            $templateKey = $webspace->getTheme()->getDefaultTemplate(Structure::TYPE_PAGE);
        }

        $result = $this->getResourceLocatorRepository()->generate(
            $parts,
            $parentUuid,
            $uuid,
            $webspaceKey,
            $languageCode,
            $templateKey
        );

        return $result;
    }
    
    /**
     * @return ResourceLocatorRepositoryInterface
     */
    protected function getResourceLocatorRepository()
    {
        return $this->container->get('sulu_content.rl_repository');
    }

    
    
}
