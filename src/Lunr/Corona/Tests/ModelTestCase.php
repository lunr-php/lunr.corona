<?php

/**
 * This file contains the ModelTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\Model;
use Lunr\Halo\LunrBaseTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * This class contains test methods for the Model class.
 *
 * @covers Lunr\Corona\Model
 */
abstract class ModelTestCase extends LunrBaseTestCase
{

    /**
     * Shared instance of the cache pool class.
     * @var CacheItemPoolInterface&MockObject
     */
    protected CacheItemPoolInterface&MockObject $cache;

    /**
     * Shared instance of the cache item class.
     * @var CacheItemInterface&MockObject
     */
    protected CacheItemInterface&MockObject $item;

    /**
     * Instance of the tested class.
     * @var Model
     */
    protected Model $class;

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->cache = $this->getMockBuilder(CacheItemPoolInterface::class)
                            ->getMock();

        $this->item = $this->getMockBuilder(CacheItemInterface::class)
                           ->getMock();

        $this->class = new Model($this->cache);

        parent::baseSetUp($this->class);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->cache);
        unset($this->item);
        unset($this->class);

        parent::tearDown();
    }

}

?>
