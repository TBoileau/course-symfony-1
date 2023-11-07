<?php

declare(strict_types=1);

namespace App\UseCase\Person;

use App\Entity\Person;
use App\Entity\User;
use App\Repository\PersonRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class PersonHandler implements CreatePersonInterface, UpdatePersonInterface, DeletePersonInterface
{
    public function __construct(
        private readonly PersonRepository $personRepository,
        private readonly TokenStorageInterface $tokenStorage
    ) {
    }

    public function create(Person $person): void
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $person->setUser($user);

        $this->personRepository->create($person);
    }

    public function delete(Person $person): void
    {
        $this->personRepository->delete($person);
    }

    public function update(Person $person): void
    {
        $this->personRepository->update($person);
    }
}
