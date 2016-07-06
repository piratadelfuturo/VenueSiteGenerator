<?php

namespace Nviba\Bundle\ToolsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Nviba\Bundle\ToolsBundle\DependencyInjection\Compiler\TwigCompilerPass;

class NvibaToolsBundle extends Bundle
{

    public function build(ContainerBuilder $container){
        parent::build($container);
        $container->addCompilerPass(new TwigCompilerPass());
    }    
    
}
