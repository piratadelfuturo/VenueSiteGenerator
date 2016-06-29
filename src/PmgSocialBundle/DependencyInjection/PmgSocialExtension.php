<?php
namespace PmgSocialBundle\DependencyInjection;

/**
 * Description of PmgSocialExtension
 *
 * @author daniel
 */
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class PmgSocialExtension extends ConfigurableExtension
{
    /**
     * {@inheritdoc}
     */
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        // $mergedConfig;
        $socialProfiles = array();
        if(array_key_exists('social_profiles',$mergedConfig)){
            $socialProfiles = $mergedConfig['social_profiles'];
        }
        $container->setParameter('pmg_social.social_profiles', $socialProfiles);
    
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
