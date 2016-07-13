<?php

namespace PmgSocialBundle\Controller;

use Sulu\Component\Content\Compat\StructureInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Gedmo\Sluggable\Util as Sluggable;
use PmgSocialBundle\Form\Type\CorpContactType;
use PmgSocialBundle\Controller\DefaultController;

class BaseController extends DefaultController
{
    
    public function homapageAction(StructureInterface $structure, $preview = false, $partial = false){
        
        $request = $this->container->get('request_stack')->getCurrentRequest();
        
        $twigContentPath = $this->container->get('sulu_website.twig.content_path');
        
        $requestAnalyzer = $this->container->get('sulu_core.webspace.request_analyzer');
        
        $socialWebspace = str_replace('_base','_social',$requestAnalyzer->getWebspace()->getKey());
        
        return $this->redirect($twigContentPath->getContentPath('/',$socialWebspace));
        
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
    public function contactAction(StructureInterface $structure, $preview = false, $partial = false)
    {
        
        $request = $this->container->get('request_stack')->getCurrentRequest();
        
        $form = $this->createForm(new CorpContactType());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                $name = $form->get('name')->getData();
                $message = \Swift_Message::newInstance()
                    ->setSubject('Website contact: '.$name.', '.$form->get('interested')->getData() )
                    ->setFrom(array($form->get('email')->getData() => $name ))
                    ->setTo('daniel@nviba.com')
                    ->setBody(
                            $form->get('details1')->getData().
                            $form->get('details2')->getData().
                            $form->get('details3')->getData().
                            $form->get('details4')->getData()
                            );

                $this->get('mailer')->send($message);

                $this->addFlash('success_form', true);
                unset($form);
                $form = $this->createForm(new CorpContactType());
        }
        
        $response = $this->renderStructure(
            $structure,
            [ 'contact_form' => $form->createView()],
            $preview,
            $partial
        );

        return $response;
    }

}
