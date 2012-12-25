<?php

namespace Ailove\FacebookBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;

use Ailove\AbstractSocialBundle\Classes\AbstractExtension;
/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AiloveFacebookExtension extends AbstractExtension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {

        //loading services first to override service classes via configuration if need

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        parent::load($configs, $container);

    }
    /**
     * @return string prefix for bundle parameters
     */
    protected function getParametersPrefix()
    {
        return 'fb.';
    }

    /**
     * {@inheritDoc}
     */
    protected function newConfiguration()
    {
        return new Configuration();
    }
}
