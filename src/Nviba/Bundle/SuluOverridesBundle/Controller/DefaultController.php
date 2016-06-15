<?php

namespace Nviba\Bundle\SuluOverridesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('NvibaSuluOverridesBundle:Default:index.html.twig');
    }
}
