<?php

declare(strict_types=1);

namespace Tanggalan\Laravel\Cache;

use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Tanggalan\Cache\CacheInterface;

/**
 * Laravel cache adapter
 *
 * Wraps Laravel's cache to implement our cache interface
 * Follows Adapter Pattern
 */
final class LaravelCache implements CacheInterface
{
    public function __construct(
        private readonly CacheRepository $cache,
        private readonly string $prefix = 'tanggalan:'
    ) {
    }

    public function get(string $key): mixed
    {
        return $this->cache->get($this->prefix . $key);
    }

    public function set(string $key, mixed $value, int $ttl = 3600): void
    {
        $this->cache->put($this->prefix . $key, $value, $ttl);
    }

    public function has(string $key): bool
    {
        return $this->cache->has($this->prefix . $key);
    }

    public function forget(string $key): void
    {
        $this->cache->forget($this->prefix . $key);
    }

    public function flush(): void
    {
        // Laravel doesn't support prefix-based flushing easily
        // This is a limitation we document
        $this->cache->flush();
    }
}
