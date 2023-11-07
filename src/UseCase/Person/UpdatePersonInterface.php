<?php

declare(strict_types=1);

namespace App\UseCase\Person;

use App\Entity\Person;

interface UpdatePersonInterface
{
    public function update(Person $person): void;
}
