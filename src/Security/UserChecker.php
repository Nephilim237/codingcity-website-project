<?php

namespace App\Security;

use App\Entity\User as AppUser;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class UserChecker implements UserCheckerInterface
{use TargetPathTrait;

    /**
     * @inheritDoc
     */
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof AppUser) {
            return;
        }

        if (!$user->isVerified()) {
            // the message passed to this exception is meant to be displayed to the user
            throw new CustomUserMessageAuthenticationException(
                'Compte inactif. Vérifier votre boite mail afin d\'activez votre compte.'
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof AppUser) {
            return;
        }
    }
}