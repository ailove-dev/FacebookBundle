<?php

namespace Ailove\FacebookBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

use Ailove\AbstractSocialBundle\Classes\AbstractConfiguration;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration extends AbstractConfiguration
{
//    /**
//     * {@inheritDoc}
//     */
//    public function getConfigTreeBuilder()
//    {
//        $treeBuilder = new TreeBuilder();
//        $rootNode = $treeBuilder->root('ailove_facebook');
//
//
//        $rootNode
//            ->children()
//                ->scalarNode('redirect_route')
//                    ->isRequired()
//                    ->cannotBeEmpty()
//                ->end()
//            ->end()
//        ;
//
//        return $treeBuilder;
//    }
    /**
     * @return string id of the root tree
     */
    protected function getTreeName()
    {
        return 'ailove_facebook';
    }


}
