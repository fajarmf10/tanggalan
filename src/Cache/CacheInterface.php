<?php

declare(strict_types=1);

namespace Tanggalan\Cache;

/**
 * Cache interface for storing conversion results
 *
 * Follows Interface Segregation Principle
 */
interface CacheInterface
{
    /**
     * Get cached value
     *
     * @param string $key Cache key
     * @return mixed Cached value or null if not found
     */
    public function get(string $key): mixed;

    /**
     * Store value in cache
     *
     * @param string $key Cache key
     * @param mixed $value Value to cache
     * @param int $ttl Time to live in seconds
     */
    public function set(string $key, mixed $value, int $ttl = 3600): void;

    /**
     * Check if key exists in cache
     */
    public function has(string $key): bool;

    /**
     * Clear specific cache key
     */
    public function forget(string $key): void;

    /**
     * Clear all cache
     */
    public function flush(): void;
}
