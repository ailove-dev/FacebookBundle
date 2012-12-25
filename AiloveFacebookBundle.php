<?php

namespace Ailove\FacebookBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Ailove\FacebookBundle\DependencyInjection\Security\Factory\FBFactory;

class AiloveFacebookBundle extends Bundle
{
    /**
     * Add security listener factory
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new FBFactory());
    }
}
