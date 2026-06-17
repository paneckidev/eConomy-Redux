<?php

declare(strict_types=1);

namespace App\SharedKernel\Application;

interface IdGenerator
{
    public function generate(): string;
}
