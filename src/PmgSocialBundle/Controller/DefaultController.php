<?php

namespace PmgSocialBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PmgSocialBundle:Default:index.html.twig');
    }
}
