<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;


class UserVoter extends Voter
{
    // these strings are just invented: you can use anything
    const VIEW = 'view';
    const EDIT = 'edit';

    protected function supports(string $attribute, $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::VIEW, self::EDIT])) {
            return false;
        }

        // only vote on `Post` objects
        if (!$subject instanceof User) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        
        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }


        switch ($attribute) {
            case self::VIEW:
                return $this->isSameUser($user, $subject);
            case self::EDIT:
                return $this->isSameUser($user, $subject);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function isSameUser(User $user1, User $user2)
    {
        return $user1 === $user2;
    }
}