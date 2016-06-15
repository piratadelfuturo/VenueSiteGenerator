<?php
namespace Nviba\Bundle\SuluOverridesBundle\DependencyInjection\Compiler;

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
class ThemeListenerCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->getParameter('sulu.context') === SuluKernel::CONTEXT_WEBSITE
                && $container->hasDefinition('nviba_sulu_overrides.event_listener.set_theme')) {

            $setThemeListenerDefinition = $container->getDefinition('nviba_sulu_overrides.event_listener.set_theme');
            
            $container->setDefinition(
                'sulu_website.event_listener.set_theme',
                $setThemeListenerDefinition
            );
        }
    }
}