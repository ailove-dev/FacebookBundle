<?php

namespace Ailove\FacebookBundle\Service;

use Symfony\Component\DependencyInjection\Container;
use Ailove\AbstractSocialBundle\Classes\AbstractSessionProxy;


class FBOauthSessionProxy extends AbstractSessionProxy
{

    /**
     * prefix to store session vars
     *
     * @return string
     */
    protected function getSessionPrefix()
    {
        return '_fb_';
    }

    /**
     * Make this method to use authorized sdk in order to fetch user's id from social network
     * @return string User's social uid
     */
    function fetchUserId()
    {
//        $user = $this->sdk->api('users.getCurrentUser');
//        return $user['uid'];
        //todo: implement
        try {
            $data = $this->sdk->api('/me');
        } catch (\FacebookApiException $e) {
            $data = null;
        }
        return $data['id'];
    }

    public function getRequiredParams()
    {
        return array(
            'accessTokenUrl',
            'dialogUrl',
            'redirectRoute',
            'scope',
        );
    }


}

