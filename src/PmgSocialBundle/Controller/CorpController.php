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

class CorpController extends DefaultController
{
    
    public function contactSendAction(Request $request){
 
        $render_params = [];
        
        $masterRequest = $this->container->get('request_stack')->getMasterRequest();
        
        if($masterRequest->get('_sulu')){
            $request = $masterRequest;
        }

        $form = $this->contactForm($request);
        $render_params['contact_form'] = $form->createView();
        
        return $this->render('PmgSocialBundle:blocks:contact.html.twig',$render_params);
    }
    
    protected function contactForm(Request $request){
        $form = $this->createForm(CorpContactType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                $name = $form->get('name')->getData();
                $message = \Swift_Message::newInstance()
                    ->setSubject('Website contact: '.$name.' - '.$form->get('interested')->getData() )
                    ->setFrom(array($form->get('email')->getData() => $name ))
                    ->setTo('daniel@nviba.com')
                    ->setBody($form->get('details1')->getData());
                $this->get('mailer')->send($message);

                $this->addFlash('contact.success_form', true);
                unset($form);
                $form = $this->createForm(CorpContactType::class);
        }
        
        return $form;        
                
    }
    

}
