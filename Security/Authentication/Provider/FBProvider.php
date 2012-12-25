<?php

namespace Ailove\FacebookBundle\Security\Authentication\Provider;

use Ailove\AbstractSocialBundle\Classes\AbstractAuthenticationProvider;
use Ailove\FacebookBundle\Security\Authentication\Token\FBUserToken as Token;

class FBProvider extends AbstractAuthenticationProvider
{
    /**
     * @{inheritDoc}
     */
    protected function getTokenClass()
    {
        return get_class(new Token());
    }

    /**
     * @{inheritDoc}
     */
    protected function getDefaultSocialRoles()
    {
        return array('ROLE_FACEBOOK_USER');
    }
}
