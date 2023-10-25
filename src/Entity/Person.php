<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PersonRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

#[Entity(repositoryClass: PersonRepository::class)]
class Person
{
    #[Id]
    #[GeneratedValue]
    #[Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[Column(type: Types::STRING)]
    private string $firstName;

    #[Column(type: Types::STRING)]
    private string $lastName;

    #[Column(type: Types::STRING)]
    private string $email;

    #[Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTimeInterface $registeredAt;

    public function __construct()
    {
        $this->registeredAt = new DateTimeImmutable();
    }

    /**
     * @param array{firstName: string, lastName: string, email: string} $person
     */
    public static function createPerson(array $person): self
    {
        $newPerson = new self();
        $newPerson->setFirstName($person['firstName']);
        $newPerson->setLastName($person['lastName']);
        $newPerson->setEmail($person['email']);

        return $newPerson;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getRegisteredAt(): ?\DateTimeInterface
    {
        return $this->registeredAt;
    }

    public function setRegisteredAt(?\DateTimeInterface $registeredAt): void
    {
        $this->registeredAt = $registeredAt;
    }
}