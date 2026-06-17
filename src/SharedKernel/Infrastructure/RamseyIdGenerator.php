<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure;

use App\SharedKernel\Application\IdGenerator;
use Ramsey\Uuid\Uuid;

final class RamseyIdGenerator implements IdGenerator
{
    public function generate(): string
    {
        return Uuid::uuid7()->toString();
    }
}
