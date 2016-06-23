<?php

namespace Nviba\Bundle\SuluOverridesBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Nviba\Bundle\SuluOverridesBundle\DependencyInjection\Compiler\ThemeListenerCompilerPass;
use Nviba\Bundle\SuluOverridesBundle\DependencyInjection\Compiler\LocationTypeCompilerPass;

class NvibaSuluOverridesBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        //$container->addCompilerPass(new ThemeListenerCompilerPass());
        $container->addCompilerPass(new LocationTypeCompilerPass());
    }
    
    
}
