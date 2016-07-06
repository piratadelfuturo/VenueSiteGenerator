<?php

namespace Nviba\Bundle\ToolsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('NvibaToolsBundle:Default:index.html.twig');
    }
}
