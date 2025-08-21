<?php

/**
 * This file contains the Model interface.
 *
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona;

use Psr\Cache\CacheItemPoolInterface;
use RuntimeException;

/**
 * Base Model class
 */
class Model
{

    /**
     * Shared instance of the cache Pool class or null.
     * @var CacheItemPoolInterface|null
     */
    protected readonly ?CacheItemPoolInterface $cache;

    /**
     * Constructor.
     *
     * @param CacheItemPoolInterface|null $cache Shared instance of the PSR-6 cache Pool class.
     */
    public function __construct(?CacheItemPoolInterface $cache = NULL)
    {
        $this->cache = $cache;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        // no-op
    }

    /**
     * Get cache item.
     *
     * @deprecated Use getFromCache() instead
     *
     * @param string $key Unique identifier for the data.
     *
     * @return mixed Cached data
     */
    protected function get_from_cache(string $key)
    {
        return $this->getFromCache($key);
    }

    /**
     * Get cache item.
     *
     * @param string $key Unique identifier for the data.
     *
     * @return mixed Cached data
     */
    protected function getFromCache(string $key): mixed
    {
        if (!isset($this->cache))
        {
            throw new RuntimeException('No Cachepool initialized!');
        }

        return $this->cache->getItem($key)->get();
    }

    /**
     * Set cache item.
     *
     * @deprecated Use setInCache() instead
     *
     * @param string $key   Unique identifier for the data.
     * @param mixed  $value Data to cache.
     * @param int    $ttl   Time To Live for cache item in seconds.
     *
     * @return bool True if successful, FALSE when value is NULL.
     */
    protected function set_in_cache(string $key, $value, int $ttl = 600): bool
    {
        return $this->setInCache($key, $value, $ttl);
    }

    /**
     * Set cache item.
     *
     * @param string $key   Unique identifier for the data.
     * @param mixed  $value Data to cache.
     * @param int    $ttl   Time To Live for cache item in seconds.
     *
     * @return bool True if successful, FALSE when value is NULL.
     */
    protected function setInCache(string $key, mixed $value, int $ttl = 600): bool
    {
        if ($value === NULL)
        {
            return FALSE;
        }

        if (!isset($this->cache))
        {
            throw new RuntimeException('No Cachepool initialized!');
        }

        $item = $this->cache->getItem($key);

        $item->expiresAfter($ttl);
        $item->set($value);

        $this->cache->save($item);

        return TRUE;
    }

    /**
     * Get an item from the cache or seed the cache if no item is present.
     *
     * @deprecated Use cacheIfNeeded() instead
     *
     * @param string                  $id       ID of the item
     * @param callable                $callable The callable to seed the cache with
     * @param array<array-key, mixed> $args     Arguments to the callback
     *
     * @return mixed Cache or Callable return
     */
    protected function cache_if_needed(string $id, callable $callable, array $args = [])
    {
        return $this->cacheIfNeeded($id, $callable, $args);
    }

    /**
     * Get an item from the cache or seed the cache if no item is present.
     *
     * @param string                  $id       ID of the item
     * @param callable                $callable The callable to seed the cache with
     * @param array<array-key, mixed> $args     Arguments to the callback
     *
     * @return mixed Cache or Callable return
     */
    protected function cacheIfNeeded(string $id, callable $callable, array $args = []): mixed
    {
        if ($this->cache === NULL)
        {
            return call_user_func_array($callable, $args);
        }

        $item = $this->cache->getItem($id);
        if ($item->isHit())
        {
            return $item->get();
        }

        $value = call_user_func_array($callable, $args);
        $this->setInCache($id, $value);

        return $value;
    }

    /**
     * Delete cache item.
     *
     * @deprecated Use deleteFromCache() instead
     *
     * @param string $key Unique identifier for the data.
     *
     * @return bool True if the item was successfully removed. False if there was an error.
     */
    protected function delete_from_cache(string $key): bool
    {
        return $this->deleteFromCache($key);
    }

    /**
     * Delete cache item.
     *
     * @param string $key Unique identifier for the data.
     *
     * @return bool True if the item was successfully removed. False if there was an error.
     */
    protected function deleteFromCache(string $key): bool
    {
        if (!isset($this->cache))
        {
            throw new RuntimeException('No Cachepool initialized!');
        }

        return $this->cache->deleteItem($key);
    }

}

?>
