<?php

namespace Nviba\Bundle\DeploymentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('NvibaDeploymentBundle:Default:index.html.twig');
    }
}
