<?php

declare(strict_types=1);

namespace App\Security\Voter;

use App\Entity\Person;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class PersonVoter extends Voter
{
    public const UPDATE = 'UPDATE';
    public const DELETE = 'DELETE';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::UPDATE, self::DELETE])
            && $subject instanceof Person;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /** @var Person $person */
        $person = $subject;

        return $person->getUser() === $user || $user->isAdmin();
    }
}
