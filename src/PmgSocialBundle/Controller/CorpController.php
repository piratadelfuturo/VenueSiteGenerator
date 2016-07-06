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
                $name = $form->get('name')->getData().' '.$form->get('last_name')->getData();
                $message = \Swift_Message::newInstance()
                    ->setSubject('Website contact: '.$name )
                    ->setFrom(array($form->get('email')->getData() => $name ))
                    ->setTo('daniel@nviba.com')
                    ->setBody($form->get('message')->getData());

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
