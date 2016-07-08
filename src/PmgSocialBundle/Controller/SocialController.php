<?php

namespace PmgSocialBundle\Controller;

use Sulu\Component\Content\Compat\StructureInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Gedmo\Sluggable\Util as Sluggable;
use PmgSocialBundle\Form\Type\ContactType;
use PmgSocialBundle\Controller\DefaultController;

class SocialController extends DefaultController
{
    
    public function sendContactAction(Request $request){
        
        
        
    }

    /**
     * Loads the content from the request (filled by the route provider) and creates a response with this content and
     * the appropriate cache headers.
     *
     * @param \Sulu\Component\Content\Compat\StructureInterface $structure
     * @param bool $preview
     * @param bool $partial
     *
     * @return Response
     */
    public function menusAction(StructureInterface $structure, $preview = false, $partial = false)
    {
                
        $request = $this->container->get('request_stack')->getCurrentRequest();
        
        $directoryPath = $this->container->getParameter('kernel.root_dir');
        $contentFilePattern = $directoryPath.'/Resources/documents/pmg_social/default/menus/'.$request->getLocale().'.yml';

        $menuData = Yaml::parse(file_get_contents($contentFilePattern));
        
        $menuKeys = array_keys($menuData);
        
        $menuIndex = array();
        
        foreach($menuKeys as $menuKey){
            $menuIndex[$menuKey] = $this->slugify($menuKey);            
        }
        
        $response = $this->renderStructure(
            $structure,
            [
                'menu' => $menuData,
                'menu_index' => $menuIndex 
            ],
            $preview,
            $partial
        );

        return $response;
    }
    
    
    protected function slugify($string) {
        $string = \transliterator_transliterate("Any-Latin; NFD; [:Nonspacing Mark:] Remove; NFC; [:Punctuation:] Remove; Lower();", $string);
        $string = preg_replace('/[-\s]+/', '-', $string);
        return trim($string, '-');
    }
}
