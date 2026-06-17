<?php

declare(strict_types=1);

namespace App\Auth\Domain\ValueObject;

use Ramsey\Uuid\Uuid;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final readonly class UserId
{
    #[ORM\Id, ORM\Column(name: 'id', type: 'string', unique: true)]
    private string $value;

    public function __construct(string $id) {
        if (!Uuid::isValid($id)) {
            throw new \InvalidArgumentException(
                sprintf('"%s" is not a valid UUID.', $id)
            );
        }

        $this->value = $id;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
