<?php

declare(strict_types=1);

namespace App\Auth\Domain\Model;

use App\Auth\Domain\ValueObject\Email;
use App\Auth\Domain\ValueObject\HashedPassword;
use App\Auth\Domain\ValueObject\UserId;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
final class User
{
    #[ORM\Embedded(class: UserId::class)]
    private UserId $id;
    #[ORM\Embedded(class: Email::class)]
    private Email $email;
    #[ORM\Embedded(class: HashedPassword::class)]
    private HashedPassword $passwordHash;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;
    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $updatedAt;

    private function __construct(
        UserId $id,
        Email $email,
        HashedPassword $passwordHash,
        \DateTimeImmutable $createdAt,
        \DateTimeImmutable $updatedAt,
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public static function register(
        UserId $id,
        Email $email,
        HashedPassword $passwordHash,
        \DateTimeImmutable $registeredAt,
    ): self {
        return new self(
            id: $id,
            email: $email,
            passwordHash: $passwordHash,
            createdAt: $registeredAt,
            updatedAt: $registeredAt,
        );
    }
}
