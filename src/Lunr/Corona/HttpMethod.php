<?php

/**
 * This file contains http methods.
 *
 * SPDX-FileCopyrightText: Copyright 2017 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona;

use BackedEnum;

/**
 * HTTP methods.
 */
enum HttpMethod: string implements ParsedEnumValueInterface
{

    /**
     * GET method.
     *
     * Request has body:  no
     * Response has body: yes
     * Safe:              yes
     * Idempotent:        yes
     *
     * @var string
     */
    public const GET = 'GET';
    case Get         = 'GET';

    /**
     * HEAD method.
     *
     * Request has body:  no
     * Response has body: no
     * Safe:              yes
     * Idempotent:        yes
     *
     * @var string
     */
    public const HEAD = 'HEAD';
    case Head         = 'HEAD';

    /**
     * POST method.
     *
     * Request has body:  yes
     * Response has body: yes
     * Safe:              no
     * Idempotent:        no
     *
     * @var string
     */
    public const POST = 'POST';
    case Post         = 'POST';

    /**
     * PUT method.
     *
     * Request has body:  yes
     * Response has body: yes
     * Safe:              no
     * Idempotent:        yes
     *
     * @var string
     */
    public const PUT = 'PUT';
    case Put         = 'PUT';

    /**
     * DELETE method.
     *
     * Request has body:  no
     * Response has body: yes
     * Safe:              no
     * Idempotent:        yes
     *
     * @var string
     */
    public const DELETE = 'DELETE';
    case Delete         = 'DELETE';

    /**
     * CONNECT method.
     *
     * Request has body:  yes
     * Response has body: yes
     * Safe:              no
     * Idempotent:        no
     *
     * @var string
     */
    public const CONNECT = 'CONNECT';
    case Connect         = 'CONNECT';

    /**
     * OPTIONS method.
     *
     * Request has body:  optional
     * Response has body: yes
     * Safe:              yes
     * Idempotent:        yes
     *
     * @var string
     */
    public const OPTIONS = 'OPTIONS';
    case Options         = 'OPTIONS';

    /**
     * TRACE method.
     *
     * Request has body:  no
     * Response has body: yes
     * Safe:              yes
     * Idempotent:        yes
     *
     * @var string
     */
    public const TRACE = 'TRACE';
    case Trace         = 'TRACE';

    /**
     * PATCH method.
     *
     * Request has body:  yes
     * Response has body: yes
     * Safe:              no
     * Idempotent:        no
     *
     * @var string
     */
    public const PATCH = 'PATCH';
    case Patch         = 'PATCH';

    /**
     * Map scalar to an enum instance.
     *
     * @param int|string|null $value The parsed request method value
     *
     * @return BackedEnum|null The requested value
     */
    public static function tryFromRequestValue(int|string|null $value): ?BackedEnum
    {
        return $value === NULL ? NULL : self::tryFrom(strtoupper($value));
    }

}

?>
