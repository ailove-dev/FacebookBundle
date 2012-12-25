<?php

namespace Ailove\FacebookBundle\Classes;


class FacebookApi extends \Facebook
{
    public function __construct($config)
    {
        $this->setAppId($config['appId']);
        $this->setAppSecret($config['secret']);
        if (isset($config['fileUpload'])) {
            $this->setFileUploadSupport($config['fileUpload']);
        }
        if (isset($config['trustForwarded']) && $config['trustForwarded']) {
            $this->trustForwarded = true;
        }
        $state = $this->getPersistentData('state');
        if (!empty($state)) {
            $this->state = $state;
        }
    }

}
