<?php

declare(strict_types=1);

namespace App\Auth\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class HashedPassword
{
    #[ORM\Column]
    private string $passwordHash;

    public function __construct(string $passwordHash)
    {
        $this->passwordHash = $passwordHash;
    }

    public function toString(): string
    {
        return $this->passwordHash;
    }
}