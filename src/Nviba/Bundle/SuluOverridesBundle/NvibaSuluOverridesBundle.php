<?php

namespace Nviba\Bundle\SuluOverridesBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Nviba\Bundle\SuluOverridesBundle\DependencyInjection\Compiler\ThemeListenerCompilerPass;

class NvibaSuluOverridesBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ThemeListenerCompilerPass());
    }
    
    
}
