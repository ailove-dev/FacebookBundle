<?php

namespace Ailove\FacebookBundle\Classes;

interface FacebookUserInterface
{

    public function getFacebookUid();
    public function setFacebookUid($uid);
    public function getFacebookData();
    public function setFacebookData($data);
}
