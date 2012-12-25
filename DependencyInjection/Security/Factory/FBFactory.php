<?php

namespace Ailove\FacebookBundle\DependencyInjection\Security\Factory;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Ailove\AbstractSocialBundle\Classes\AbstractFactory;

class FBFactory extends AbstractFactory
{
    /**
     * @{inheritDoc}
     */
    function getServicePrefix()
    {
        return 'fb';
    }

}
