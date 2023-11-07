<?php

declare(strict_types=1);

namespace App\UseCase\Person;

use App\Entity\Person;

interface DeletePersonInterface
{
    public function delete(Person $person): void;
}
