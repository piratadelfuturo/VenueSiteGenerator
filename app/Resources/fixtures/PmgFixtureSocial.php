<?php
use Sulu\Component\DocumentManager\DocumentManager;
use Sulu\Bundle\ContentBundle\Document\BasePageDocument;
use Sulu\Bundle\DocumentManagerBundle\DataFixtures\DocumentFixtureInterface;
use Sulu\Component\Content\Document\WorkflowStage;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Description of PmgFixture
 *
 * @author daniel
 */
class PmgFixtureSocial implements DocumentFixtureInterface, ContainerAwareInterface{
    
    private $container;
    
    private $documentManager;
    
    CONST CONTENT_FILE_LOCATION = '/Resources/fixtures/Data/social/content.yml';
        
    public function getLocales(){
        
        return ['en','fr'];
    }
    
    public function getDefaultLocale(){
        
        return 'en';
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
        $directoryPath = $this->container->getParameter('kernel.root_dir');        
        $value = Yaml::parse(file_get_contents($directoryPath.self::CONTENT_FILE_LOCATION));
        $sitesData = $value['sites'];
        
        $homeDocuments = array();
        $webspaceManager = $this->container->get('sulu_core.webspace.webspace_manager');
        $this->documentManager = $documentManager;
        $webspaces = $webspaceManager->getWebspaceCollection();
        foreach($webspaces as $webspace){
            if(array_key_exists($webspace->getKey(), $sitesData)){
                echo $webspace->getKey()."\n";

                $this->generateDocuments($webspace,$sitesData);
            }
        }
    }
    
    protected function generateDocuments($webspace,$sitesData){
        $webspaceKey = $webspace->getKey();
        $webspaceContent = $sitesData[$webspaceKey];

        $homeDocuments[$webspaceKey] = $this->generateHomepageDocuments(
                $webspaceKey,
                $webspaceContent['homepage']
                );
        $this->generateHallsDocuments(
                $homeDocuments[$webspaceKey]
                );
        $this->generateMenusDocuments(
                $homeDocuments[$webspaceKey]
                );
        $this->generateTestimonialDocuments(
                $homeDocuments[$webspaceKey]
                );
        $this->generateContactDocuments(
                $homeDocuments[$webspaceKey]
                );        
    }
    
    protected function loadPageFromData(BasePageDocument $document, $data, BasePageDocument $parentDocument = null){
        
        $documentManager    = $this->documentManager;
        $locales            = $this->getLocales();
        
        $structureType      = $data['structureType'];
        $documentContents   = $data['content'];
        $defaultTitle       = isset($data['title']) ? $data['title'] : 'page';
        $documentNavigation = isset($data['navigationContexts']) ? $data['navigationContexts']: [];
        
        $defaultLocale      = $this->getDefaultLocale();
        $defaultData        = isset($documentContents[$defaultLocale]['fields']) ? $documentContents[$defaultLocale]['fields'] : null;
        
        $pathName           = $document->getPath();
        
        $document->setStructureType($structureType);
        $document->setWorkflowStage(WorkflowStage::PUBLISHED);        

        if(is_null($defaultData) && !empty($documentContents)){
            foreach($locales as $localePosition){
                if(isset($documentContents[$localePosition]['fields'])){
                    $defaultData = $documentContents[$localePosition]['fields'];
                    $defaultLocale = $localePosition;
                    break;                    
                }else{
                    $defaultData = null;
                }
            }            
        }        
        
        foreach($locales as $locale){
            if(isset($documentContents[$locale]['fields']))
            {
                $documentData = $documentContents[$locale]['fields'];                
            }
            elseif(!is_null($defaultData))
            {
                $documentData = $defaultData;
            }else{
                $documentData = array();
            }
            $documentTitle = isset($documentContents[$locale]['title']) ? $documentContents[$locale]['title']: $defaultTitle;
            
            $document->setTitle($documentTitle);
            $document->getStructure()->bind($documentData);
            $document->setLocale($locale);
            $options = [
                'auto_create' => true,
                'load_ghost_content'    => false
            ];
            $document->setNavigationContexts($documentNavigation);
            
            if((empty($documentData) && $locale !== $defaultLocale)
                    || (isset($documentContents[$locale]['shadow']) ? ($documentContents[$locale]['shadow']) :  false)){
                $document->setShadowLocale($defaultLocale);
                $document->setShadowLocaleEnabled(true);                
                $options['load_ghost_content'] = true;
            }
            
            if(!is_null($parentDocument)){
                $resource = $this->generateRLAction(
                    $parentDocument->getUuid(),
                    $document->getUuid(),
                    array('title' => $documentTitle),
                    $structureType,
                    $parentDocument->getWebspaceName(),
                    $locale
                );
                $document->setParent($parentDocument);
                $document->setResourceSegment($resource['resourceLocator']);
                $options['parent_path'] = $parentDocument->getPath();
            }else{
                $options['path'] = $pathName;
            }
            
            $document->setExtension(
                'excerpt',
                [
                    'title' => $defaultTitle,
                    'description' => 'description',
                    'categories' => [],
                    'tags' => []
                ]
            );
            
            $documentManager->persist(
                $document,
                $locale,
                $options
            );
            $documentManager->flush();
        }
        
        return $document;        
    }
    
    /**
     * Create a webspace node with the given locales.
     *
     * @param string $name
     * @param string[] $locales
     */
    protected function generateHomepageDocuments($name, $data)
    {
        $documentManager = $this->documentManager;
        $pathName = '/cmf/'.$name.'/contents';
        $homeDocument = $documentManager->find($pathName);
                
        $homeDocument = $this->loadPageFromData($homeDocument,$data);
        
        return $homeDocument;
    }
    
    protected function generateHallsDocuments(BasePageDocument $parentDocument, $data = null) {
        $documentManager = $this->documentManager;        
        $page = $documentManager->create('page');
        
        if(is_null($data) || empty($data)){
            $data = array();
            $data['structureType'] = 'halls';
            $data['content'] = array();
            $data['title'] = 'Our Halls';
            $data['navigationContexts'] = ['main'];
        }
        
        $page = $this->loadPageFromData($page, $data, $parentDocument);
        
        return $page;
        
    }
    
    protected function generateMenusDocuments(BasePageDocument $parentDocument, $data = null) {
        $templateKey = 'menus';
        $documentManager = $this->documentManager;        
        $page = $documentManager->create('page');
        
        if(is_null($data) || empty($data)){
            $data = array();
            $data['structureType'] = $templateKey;
            $data['content'] = array();
            $data['title'] = 'Our Menus';
            $data['navigationContexts'] = ['main'];
        }
        
        $page = $this->loadPageFromData($page, $data, $parentDocument);
        
        return $page;

    }
    
    protected function generateTestimonialDocuments(BasePageDocument $parentDocument, $data = null){
        $templateKey = 'testimonials';
        $documentManager = $this->documentManager;        
        $page = $documentManager->create('page');
        
        if(is_null($data) || empty($data)){
            $data = array();
            $data['structureType'] = $templateKey;
            $data['content'] = array();
            $data['title'] = 'Testimonials';
            $data['navigationContexts'] = ['main'];
        }
        
        $page = $this->loadPageFromData($page, $data, $parentDocument);
        
        return $page;
        
    }
    
    protected function generateContactDocuments(BasePageDocument $parentDocument, $data = null){
        
        $templateKey = 'contact';
        $documentManager = $this->documentManager;        
        $page = $documentManager->create('page');
        
        if(is_null($data) || empty($data)){
            $data = array();
            $data['structureType'] = $templateKey;
            $data['content'] = array();
            $data['title'] = 'Contact';
            $data['navigationContexts'] = ['main'];
        }
        
        $page = $this->loadPageFromData($page, $data, $parentDocument);
        
        return $page;
        
        
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
