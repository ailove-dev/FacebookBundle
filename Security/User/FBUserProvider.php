<?php


namespace Ailove\FacebookBundle\Security\User;

use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;

use Ailove\AbstractSocialBundle\Classes\AbstractUserProvider;
use Ailove\FacebookBundle\Classes\FacebookUserInterface;

class FBUserProvider extends AbstractUserProvider
{
    /**
     * Find user by social uid.
     *
     * @param string $uid user social uid
     * @return \FOS\UserBundle\Model\UserInterface
     * @throws UsernameNotFoundException
     *
     */
    public function findUserByUid($uid)
    {
        return $this->userManager->findUserBy(array('facebookUid' => $uid));
    }

    /**
     * {@inheritDoc}
     */
    public function getUserUid(UserInterface $user)
    {
        if (!$user instanceof FacebookUserInterface)
            throw new UnsupportedUserException('User is not supported');

        return $user->getFacebookUid();
    }

}
