<?php

declare(strict_types=1);

namespace Tanggalan\Cache;

/**
 * Simple in-memory array cache
 *
 * Useful for non-Laravel applications or when persistent cache is not needed
 * Cache is cleared when PHP process ends
 */
final class ArrayCache implements CacheInterface
{
    /**
     * @var array<string, array{value: mixed, expires_at: int}>
     */
    private array $cache = [];

    public function get(string $key): mixed
    {
        if (!$this->has($key)) {
            return null;
        }

        return $this->cache[$key]['value'];
    }

    public function set(string $key, mixed $value, int $ttl = 3600): void
    {
        $this->cache[$key] = [
            'value' => $value,
            'expires_at' => time() + $ttl,
        ];
    }

    public function has(string $key): bool
    {
        if (!isset($this->cache[$key])) {
            return false;
        }

        // Check if expired
        if ($this->cache[$key]['expires_at'] < time()) {
            unset($this->cache[$key]);
            return false;
        }

        return true;
    }

    public function forget(string $key): void
    {
        unset($this->cache[$key]);
    }

    public function flush(): void
    {
        $this->cache = [];
    }
}
