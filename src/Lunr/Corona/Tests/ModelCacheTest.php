<?php

/**
 * This file contains the ModelCacheTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\Model;
use RuntimeException;

/**
 * This class contains test methods for the Model class.
 *
 * @covers Lunr\Corona\Model
 */
class ModelCacheTest extends ModelTestCase
{

    /**
     * Test that getFromCache() throws an exception if there's no cachepool.
     *
     * @covers \Lunr\Corona\Model::getFromCache
     */
    public function testGetFromCacheThrowsExceptionWithoutCachePool(): void
    {
        $class = new Model();

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('No Cachepool initialized!');

        $method = $this->getReflectionMethod('getFromCache');

        $method->invokeArgs($class, [ 'foo' ]);
    }

    /**
     * Test that getFromCache() returns the stored value from cache.
     *
     * @covers \Lunr\Corona\Model::getFromCache
     */
    public function testGetFromCache(): void
    {
        $this->cache->expects($this->once())
                    ->method('getItem')
                    ->with('foo')
                    ->willReturn($this->item);

        $this->item->expects($this->once())
                   ->method('get')
                   ->willReturn('bar');

        $method = $this->getReflectionMethod('getFromCache');

        $result = $method->invokeArgs($this->class, [ 'foo' ]);

        $this->assertEquals('bar', $result);
    }

    /**
     * Test that get_from_cache() returns the stored value from cache.
     *
     * @covers \Lunr\Corona\Model::get_from_cache
     */
    public function testDeprecatedGetFromCache(): void
    {
        $this->cache->expects($this->once())
                    ->method('getItem')
                    ->with('foo')
                    ->willReturn($this->item);

        $this->item->expects($this->once())
                   ->method('get')
                   ->willReturn('bar');

        $method = $this->getReflectionMethod('get_from_cache');

        $result = $method->invokeArgs($this->class, [ 'foo' ]);

        $this->assertEquals('bar', $result);
    }

    /**
     * Test that setInCache() throws an exception if there's no cachepool.
     *
     * @covers \Lunr\Corona\Model::setInCache
     */
    public function testSetInCacheThrowsExceptionWithoutCachePool(): void
    {
        $class = new Model();

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('No Cachepool initialized!');

        $method = $this->getReflectionMethod('setInCache');

        $method->invokeArgs($class, [ 'foo', 'bar' ]);
    }

    /**
     * Test that setInCache() does not store NULL in cache.
     *
     * @covers \Lunr\Corona\Model::setInCache
     */
    public function testSetInCacheWithNullValue(): void
    {
        $this->cache->expects($this->never())
                    ->method('getItem');

        $this->cache->expects($this->never())
                    ->method('save');

        $method = $this->getReflectionMethod('setInCache');

        $result = $method->invokeArgs($this->class, [ 'foo', NULL ]);

        $this->assertFalse($result);
    }

    /**
     * Test that set_in_cache() does not store NULL in cache.
     *
     * @covers \Lunr\Corona\Model::set_in_cache
     */
    public function testDeprecatedSetInCacheWithNullValue(): void
    {
        $this->cache->expects($this->never())
                    ->method('getItem');

        $this->cache->expects($this->never())
                    ->method('save');

        $method = $this->getReflectionMethod('set_in_cache');

        $result = $method->invokeArgs($this->class, [ 'foo', NULL ]);

        $this->assertFalse($result);
    }

    /**
     * Test that setInCache() stores value in cache.
     *
     * @covers \Lunr\Corona\Model::setInCache
     */
    public function testSetInCache(): void
    {
        $this->cache->expects($this->once())
                    ->method('getItem')
                    ->with('foo')
                    ->willReturn($this->item);

        $this->cache->expects($this->once())
                    ->method('save')
                    ->with($this->item);

        $this->item->expects($this->once())
                   ->method('expiresAfter')
                   ->with(600);

        $this->item->expects($this->once())
                   ->method('set')
                   ->with('bar');

        $method = $this->getReflectionMethod('setInCache');

        $result = $method->invokeArgs($this->class, [ 'foo', 'bar' ]);

        $this->assertTrue($result);
    }

    /**
     * Test that set_in_cache() stores value in cache.
     *
     * @covers \Lunr\Corona\Model::set_in_cache
     */
    public function testDeprecatedSetInCache(): void
    {
        $this->cache->expects($this->once())
                    ->method('getItem')
                    ->with('foo')
                    ->willReturn($this->item);

        $this->cache->expects($this->once())
                    ->method('save')
                    ->with($this->item);

        $this->item->expects($this->once())
                   ->method('expiresAfter')
                   ->with(600);

        $this->item->expects($this->once())
                   ->method('set')
                   ->with('bar');

        $method = $this->getReflectionMethod('set_in_cache');

        $result = $method->invokeArgs($this->class, [ 'foo', 'bar' ]);

        $this->assertTrue($result);
    }

    /**
     * Test that setInCache() stores value in cache with a custom expiry time.
     *
     * @covers \Lunr\Corona\Model::setInCache
     */
    public function testSetInCacheWithCustomExpiryTime(): void
    {
        $this->cache->expects($this->once())
                    ->method('getItem')
                    ->with('foo')
                    ->willReturn($this->item);

        $this->cache->expects($this->once())
                    ->method('save')
                    ->with($this->item);

        $this->item->expects($this->once())
                   ->method('expiresAfter')
                   ->with(300);

        $this->item->expects($this->once())
                   ->method('set')
                   ->with('bar');

        $method = $this->getReflectionMethod('setInCache');

        $result = $method->invokeArgs($this->class, [ 'foo', 'bar', 300 ]);

        $this->assertTrue($result);
    }

    /**
     * Test that set_in_cache() stores value in cache with a custom expiry time.
     *
     * @covers \Lunr\Corona\Model::set_in_cache
     */
    public function testDeprecatedSetInCacheWithCustomExpiryTime(): void
    {
        $this->cache->expects($this->once())
                    ->method('getItem')
                    ->with('foo')
                    ->willReturn($this->item);

        $this->cache->expects($this->once())
                    ->method('save')
                    ->with($this->item);

        $this->item->expects($this->once())
                   ->method('expiresAfter')
                   ->with(300);

        $this->item->expects($this->once())
                   ->method('set')
                   ->with('bar');

        $method = $this->getReflectionMethod('set_in_cache');

        $result = $method->invokeArgs($this->class, [ 'foo', 'bar', 300 ]);

        $this->assertTrue($result);
    }

    /**
     * Test that cacheIfNeeded() returns the cache item if one is found.
     *
     * @covers \Lunr\Corona\Model::cacheIfNeeded
     */
    public function testCacheIfNeededReturnsWithoutCache(): void
    {
        $class = new Model();

        $this->cache->expects($this->never())
                    ->method('getItem');

        $this->item->expects($this->never())
                   ->method('isHit');

        $method = $this->getReflectionMethod('cacheIfNeeded');

        $result = $method->invokeArgs($class, [ 'foo', fn($param) => 'test ' . $param, [ 'param' ] ]);

        $this->assertEquals('test param', $result);
    }

    /**
     * Test that cache_if_needed() returns the cache item if one is found.
     *
     * @covers \Lunr\Corona\Model::cache_if_needed
     */
    public function testDeprecatedCacheIfNeededReturnsWithoutCache(): void
    {
        $class = new Model();

        $this->cache->expects($this->never())
                    ->method('getItem');

        $this->item->expects($this->never())
                   ->method('isHit');

        $method = $this->getReflectionMethod('cache_if_needed');

        $result = $method->invokeArgs($class, [ 'foo', fn($param) => 'test ' . $param, [ 'param' ] ]);

        $this->assertEquals('test param', $result);
    }

    /**
     * Test that cacheIfNeeded() returns the cache item if one is found.
     *
     * @covers \Lunr\Corona\Model::cacheIfNeeded
     */
    public function testCacheIfNeededReturnsFromCacheIfFound(): void
    {
        $this->cache->expects($this->once())
                    ->method('getItem')
                    ->with('foo')
                    ->willReturn($this->item);

        $this->item->expects($this->once())
                   ->method('isHit')
                   ->willReturn(TRUE);

        $this->item->expects($this->once())
                   ->method('get')
                   ->willReturn('bar');

        $method = $this->getReflectionMethod('cacheIfNeeded');

        $result = $method->invokeArgs($this->class, [ 'foo', fn() => 'test' ]);

        $this->assertEquals('bar', $result);
    }

    /**
     * Test that cache_if_needed() returns the cache item if one is found.
     *
     * @covers \Lunr\Corona\Model::cache_if_needed
     */
    public function testDeprecatedCacheIfNeededReturnsFromCacheIfFound(): void
    {
        $this->cache->expects($this->once())
                    ->method('getItem')
                    ->with('foo')
                    ->willReturn($this->item);

        $this->item->expects($this->once())
                   ->method('isHit')
                   ->willReturn(TRUE);

        $this->item->expects($this->once())
                   ->method('get')
                   ->willReturn('bar');

        $method = $this->getReflectionMethod('cache_if_needed');

        $result = $method->invokeArgs($this->class, [ 'foo', fn() => 'test' ]);

        $this->assertEquals('bar', $result);
    }

    /**
     * Test that cacheIfNeeded() returns the cache item if one is found.
     *
     * @covers \Lunr\Corona\Model::cacheIfNeeded
     */
    public function testCacheIfNeededCachesWhenNeeded(): void
    {
        $this->cache->expects($this->exactly(2))
                    ->method('getItem')
                    ->with('foo')
                    ->willReturn($this->item);

        $this->item->expects($this->once())
                   ->method('isHit')
                   ->willReturn(FALSE);

        $this->item->expects($this->never())
                   ->method('get');

        $this->item->expects($this->once())
                   ->method('expiresAfter')
                   ->with(600);

        $this->item->expects($this->once())
                   ->method('set')
                   ->with('test');

        $this->cache->expects($this->once())
                    ->method('save')
                    ->with($this->item);

        $method = $this->getReflectionMethod('cacheIfNeeded');

        $result = $method->invokeArgs($this->class, [ 'foo', fn() => 'test' ]);

        $this->assertEquals('test', $result);
    }

    /**
     * Test that cache_if_needed() returns the cache item if one is found.
     *
     * @covers \Lunr\Corona\Model::cache_if_needed
     */
    public function testDeprecatedCacheIfNeededCachesWhenNeeded(): void
    {
        $this->cache->expects($this->exactly(2))
                    ->method('getItem')
                    ->with('foo')
                    ->willReturn($this->item);

        $this->item->expects($this->once())
                   ->method('isHit')
                   ->willReturn(FALSE);

        $this->item->expects($this->never())
                   ->method('get');

        $this->item->expects($this->once())
                   ->method('expiresAfter')
                   ->with(600);

        $this->item->expects($this->once())
                   ->method('set')
                   ->with('test');

        $this->cache->expects($this->once())
                    ->method('save')
                    ->with($this->item);

        $method = $this->getReflectionMethod('cache_if_needed');

        $result = $method->invokeArgs($this->class, [ 'foo', fn() => 'test' ]);

        $this->assertEquals('test', $result);
    }

    /**
     * Test that cacheIfNeeded() returns the cache item if one is found.
     *
     * @covers \Lunr\Corona\Model::cacheIfNeeded
     */
    public function testCacheIfNeededCachesWhenNeededWithArgs(): void
    {
        $this->cache->expects($this->exactly(2))
                    ->method('getItem')
                    ->with('foo')
                    ->willReturn($this->item);

        $this->item->expects($this->once())
                   ->method('isHit')
                   ->willReturn(FALSE);

        $this->item->expects($this->never())
                   ->method('get');

        $this->item->expects($this->once())
                   ->method('expiresAfter')
                   ->with(600);

        $this->item->expects($this->once())
                   ->method('set')
                   ->with('test param');

        $this->cache->expects($this->once())
                    ->method('save')
                    ->with($this->item);

        $method = $this->getReflectionMethod('cacheIfNeeded');

        $result = $method->invokeArgs($this->class, [ 'foo', fn($param) => 'test ' . $param, [ 'param' ] ]);

        $this->assertEquals('test param', $result);
    }

    /**
     * Test that cache_if_needed() returns the cache item if one is found.
     *
     * @covers \Lunr\Corona\Model::cache_if_needed
     */
    public function testDeprecatedCacheIfNeededCachesWhenNeededWithArgs(): void
    {
        $this->cache->expects($this->exactly(2))
                    ->method('getItem')
                    ->with('foo')
                    ->willReturn($this->item);

        $this->item->expects($this->once())
                   ->method('isHit')
                   ->willReturn(FALSE);

        $this->item->expects($this->never())
                   ->method('get');

        $this->item->expects($this->once())
                   ->method('expiresAfter')
                   ->with(600);

        $this->item->expects($this->once())
                   ->method('set')
                   ->with('test param');

        $this->cache->expects($this->once())
                    ->method('save')
                    ->with($this->item);

        $method = $this->getReflectionMethod('cache_if_needed');

        $result = $method->invokeArgs($this->class, [ 'foo', fn($param) => 'test ' . $param, [ 'param' ] ]);

        $this->assertEquals('test param', $result);
    }

    /**
     * Test that deleteFromCache() throws an exception if there's no cachepool.
     *
     * @covers \Lunr\Corona\Model::deleteFromCache
     */
    public function testDeleteFromCacheThrowsExceptionWithoutCachePool(): void
    {
        $class = new Model();

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('No Cachepool initialized!');

        $method = $this->getReflectionMethod('deleteFromCache');

        $method->invokeArgs($class, [ 'foo' ]);
    }

    /**
     * Test that deleteFromCache() deletes value from cache.
     *
     * @covers \Lunr\Corona\Model::deleteFromCache
     */
    public function testDeleteFromCache(): void
    {
        $this->cache->expects($this->once())
                    ->method('deleteItem')
                    ->with('foo')
                    ->willReturn(TRUE);

        $method = $this->getReflectionMethod('deleteFromCache');

        $method->invokeArgs($this->class, [ 'foo' ]);
    }

    /**
     * Test that delete_from_cache() deletes value from cache.
     *
     * @covers \Lunr\Corona\Model::delete_from_cache
     */
    public function testDeprecatedDeleteFromCache(): void
    {
        $this->cache->expects($this->once())
                    ->method('deleteItem')
                    ->with('foo')
                    ->willReturn(TRUE);

        $method = $this->getReflectionMethod('delete_from_cache');

        $method->invokeArgs($this->class, [ 'foo' ]);
    }

}

?>
