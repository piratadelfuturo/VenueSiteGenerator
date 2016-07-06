<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Nviba\Bundle\ToolsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;


/**
 * Description of TwigCompilerPass
 *
 * @author daniel
 */
class TwigCompilerPass implements CompilerPassInterface{

    public function process(ContainerBuilder $container)
    {
        /*
        $container->setParameter(
            'nviba_tools.intl.twig_extension',
            $this->loadThemeFormats($container->getParameter('sulu_media.format_manager.default_imagine_options'))
        );
         */

    }
    
}
