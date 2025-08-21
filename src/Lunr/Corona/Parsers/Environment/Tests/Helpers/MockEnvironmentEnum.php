<?php

/**
 * This file contains a mock environment enum.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Environment\Tests\Helpers;

use BackedEnum;
use Lunr\Corona\ParsedEnumValueInterface;

/**
 * Request Data Enums
 */
enum MockEnvironmentEnum: string implements ParsedEnumValueInterface
{

    /**
     * Mock value.
     */
    case Production = 'production';

    /**
     * Mock value.
     */
    case Test = 'test';

    /**
     * Map scalar to an enum instance or NULL.
     *
     * This could just be an alias for BackedEnum::tryFrom(), but allows for more flexibility when needed.
     *
     * @param scalar|null $value The parsed request value
     *
     * @return BackedEnum&ParsedEnumValueInterface|null The requested value
     */
    public static function tryFromRequestValue(int|string|null $value): ?BackedEnum
    {
        return $value === NULL ? NULL : self::tryFrom($value);
    }

}

?>
