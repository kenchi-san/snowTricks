<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class CommentVoter extends Voter
{
    const COMMENT_EDIT = 'COMMENT_EDIT';
    const COMMENT_DELETE = 'COMMENT_DELETE';

    /**
     * @param string $attribute
     * @param mixed $subject
     * @return bool
     */
    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::COMMENT_EDIT, self::COMMENT_DELETE])
            && $subject instanceof \App\Entity\Comment;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        $comment = $subject;
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::COMMENT_EDIT:
            case self::COMMENT_DELETE:
                return $this->owner($comment, $user);
        }

        return false;

    }

    private function owner($comment, ?User $user): bool
    {
        if ($user->getId() == $comment->getUser()->getId()) {
            return true;
        }
        return false;
    }


}
