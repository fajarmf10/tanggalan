<?php

declare(strict_types=1);

namespace Tanggalan\Cache;

/**
 * Null cache implementation (no caching)
 *
 * Follows Null Object Pattern - does nothing but implements the interface
 */
final class NullCache implements CacheInterface
{
    public function get(string $key): mixed
    {
        return null;
    }

    public function set(string $key, mixed $value, int $ttl = 3600): void
    {
        // Do nothing
    }

    public function has(string $key): bool
    {
        return false;
    }

    public function forget(string $key): void
    {
        // Do nothing
    }

    public function flush(): void
    {
        // Do nothing
    }
}
