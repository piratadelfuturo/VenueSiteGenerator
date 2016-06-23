<?php
namespace Nviba\Bundle\SuluOverridesBundle\DependencyInjection\Compiler;

/**
 * Description of LocationTypeCompilerPass
 *
 * @author daniel
 */

use Sulu\Component\HttpKernel\SuluKernel;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Sulu\Bundle\WebsiteBundle\Templating\EngineEvents;

/**
 * Description of ThemeListenerCompilerPass
 *
 * @author daniel
 */
class LocationTypeCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->hasDefinition('sulu_location.content.type.location')) {

            $typeDefinition = $container->getDefinition('sulu_location.content.type.location');
            
            $typeDefinition->setClass('Nviba\Bundle\SuluOverridesBundle\Content\Types\LocationContentType');
        }
    }
}