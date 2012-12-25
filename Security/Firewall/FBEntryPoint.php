<?php

namespace Ailove\FacebookBundle\Security\Firewall;

use Ailove\AbstractSocialBundle\Classes\AbstractEntryPoint;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Ailove\FacebookBundle\Security\Authentication\Token\FBUserToken;

class FBEntryPoint extends AbstractEntryPoint
{
    /**
     * {@inheritDoc}
     */
    protected function getSessionProxy()
    {
        return $this->container->get('fb.oauth.proxy');
    }

    /**
     * {@inheritDoc}
     */
    protected function supportsToken(TokenInterface $token)
    {
        if ($token instanceof FBUserToken)
            return true;

        return false;
    }

}
