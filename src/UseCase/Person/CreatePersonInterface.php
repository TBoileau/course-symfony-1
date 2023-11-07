<?php

declare(strict_types=1);

namespace App\UseCase\Person;

use App\Entity\Person;

interface CreatePersonInterface
{
    public function create(Person $person): void;
}
