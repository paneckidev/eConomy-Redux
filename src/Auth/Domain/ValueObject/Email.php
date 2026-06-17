<?php

declare(strict_types=1);

namespace App\Auth\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class Email
{
    #[ORM\Column(name: 'email', unique: true)]
    private string $value;

    public function __construct(string $email)
    {
        $normalized = strtolower(trim($email));

        if (!filter_var($normalized, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email address');
        }

        $this->value = $normalized;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
