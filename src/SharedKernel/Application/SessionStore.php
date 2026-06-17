<?php

declare(strict_types=1);

namespace App\SharedKernel\Application;

interface SessionStore
{
    public function start(): void;

    public function enforceInactivityTimeout(int $seconds): void;

    public function set(string $key, mixed $value): void;

    public function get(string $key): mixed;

    public function has(string $key): bool;

    public function remove(string $key): void;

    public function destroy(): void;

    public function regenerateId(): void;
}