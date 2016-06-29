<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PmgSocialBundle\DependencyInjection;

/**
 * Description of PmgSocialConfiguration
 *
 * @author daniel
 */
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('pmg_social');
        $rootNode->children()
                    ->arrayNode('social_profiles')
                        ->prototype('variable')->end()
                ->end();

        // ... add node definitions to the root of the tree

        return $treeBuilder;
    }
}