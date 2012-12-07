<?php

/**
 * This file is part of the "AiloveOliport" package.
 *
 * Copyright Ailove company <info@ailove.ru>
 *
 */

namespace Ailove\FacebookBundle\Security\Facebook\User;

use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use FOS\UserBundle\Entity\UserManager;
use Ailove\UserBundle\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\DependencyInjection\Container;
use \BaseFacebook;
use \FacebookApiException;

/**
 * Facebook user provider.
 *
 * @author Dmitry Bykadorov <dmitry.bykadorov@gmail.com>
 */
class FacebookUserProvider implements UserProviderInterface
{
    /**
     * @var \Facebook
     */
    protected $facebook;

    /**
     * @var \FOS\UserBundle\Entity\UserManager
     */
    protected $userManager;

    /**
     * @var \Symfony\Component\Validator\Validator
     */
    protected $validator;

    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    protected $serviceContainer;

    /**
     * @var \Symfony\Bridge\Monolog\Logger
     */
    protected $logger;

    /**
     * Constructor.
     *
     * @param \BaseFacebook                                    $facebook         Facebook api instance
     * @param \FOS\UserBundle\Entity\UserManager               $userManager      User manager
     * @param \Symfony\Component\Validator\Validator           $validator        Symfony validator
     * @param \Symfony\Component\DependencyInjection\Container $serviceContainer Symfony DI container
     */
    public function __construct(BaseFacebook $facebook, $userManager, $validator, Container $serviceContainer)
    {
        $this->facebook = $facebook;
        $this->userManager = $userManager;
        $this->validator = $validator;
        $this->serviceContainer = $serviceContainer;
        $this->logger = $this->serviceContainer->get('logger');
    }

    /**
     * Check class support.
     *
     * @param string $class Class name
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return $this->userManager->supportsClass($class);
    }

    /**
     * Find User by facebook uid.
     *
     * @param integer $fbId Facebook user ID
     *
     * @return \Ailove\UserBundle\Entity\User
     *
     * @throws \Exception
     */
    public function findUserByFbId($fbId)
    {
        if (empty($fbId)) {
            throw new \Exception('Facebook ID не определён');
        }

        return $this->userManager->findUserBy(array('facebookUid' => $fbId));
    }

    /**
     * Find or create User by facebook uid.
     *
     * @param string $username Facebook uid
     *
     * @return \Ailove\UserBundle\Entity\User
     *
     * @throws \Symfony\Component\Security\Core\Exception\UsernameNotFoundException
     */
    public function loadUserByUsername($username)
    {
        /** @var $user \Ailove\UserBundle\Entity\User */
        $user = $this->findUserByFbId($username);
        try {
            $fbdata = $this->facebook->api('/me');
        } catch (\FacebookApiException $e) {
            $fbdata = null;
        }


        if (empty($user)) {

            if (!empty($fbdata)) {


                $username = $fbdata['id'] . '@facebook.com';
                $user = $this->userManager->createUser();
                $user->setFirstname($fbdata['first_name']);
                $user->setLastname($fbdata['last_name']);
                $user->setEnabled(true); // Temporary enable user - to access connect page
                $user->setPassword('');
                $user->setFacebookData($fbdata);
                $user->setEmail($username);
                $user->addRole(User::ROLE_FACEBOOK_USER);
                $user->setFacebookUid($fbdata['id']);
                $user->setUsername($username);
                $user->setAvatar('https://graph.facebook.com/' . $user->getFacebookUid() . '/picture?width=72&height=72');
                $this->userManager->updateUser($user, false);
            }
        }

        if (empty($user)) {
            throw new UsernameNotFoundException('The user is not authenticated on facebook');
        }

        if ($fbdata) {
            $user->setFacebookName($fbdata['name']);
        }

//        var_dump($user);die;

        return $user;
    }

    /**
     * Refresh user.
     *
     * @param \Symfony\Component\Security\Core\User\UserInterface $user User instnace
     *
     * @return \Ailove\UserBundle\Entity\User|\FOS\UserBundle\Model\UserInterface
     *
     * @throws \Symfony\Component\Security\Core\Exception\UnsupportedUserException
     */
    public function refreshUser(UserInterface $user)
    {
        /** @var $user \Ailove\UserBundle\Entity\User */
        if (!$this->supportsClass(get_class($user)) || !$user->getFacebookUid()) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getFacebookUid());
    }
}
