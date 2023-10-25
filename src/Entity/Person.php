<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PersonRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\{Column, Entity, GeneratedValue, Id, JoinColumn, ManyToOne};
use Symfony\Component\Validator\Constraints\{Email, NotBlank};

#[Entity(repositoryClass: PersonRepository::class)]
class Person
{
    #[Id]
    #[GeneratedValue]
    #[Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[Column(type: Types::STRING)]
    #[NotBlank]
    private string $firstName;

    #[Column(type: Types::STRING)]
    #[NotBlank]
    private string $lastName;

    #[Column(type: Types::STRING)]
    #[NotBlank]
    #[Email]
    private string $email;

    #[Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTimeInterface $registeredAt;

    #[ManyToOne(inversedBy: 'persons')]
    #[JoinColumn(nullable: false)]
    private Group $group;

    public function __construct()
    {
        $this->registeredAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRegisteredAt(): ?DateTimeInterface
    {
        return $this->registeredAt;
    }

    public function getGroup(): Group
    {
        return $this->group;
    }

    public function setGroup(Group $group): self
    {
        $this->group = $group;

        return $this;
    }
}