<?php

/**
 * This file contains a mock API version enum.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Client\Tests\Helpers;

use BackedEnum;
use Lunr\Corona\ParsedEnumValueInterface;
use Lunr\Corona\Parsers\Client\ClientInterface;

/**
 * Request Data Enums
 */
enum MockClientEnum: string implements ParsedEnumValueInterface, ClientInterface
{

    /**
     * Mock value.
     */
    case CommandLine = 'Command Line';

    /**
     * Mock value.
     */
    case Website = 'Website';

    /**
     * Mock value.
     */
    case Developer = 'Developer';

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

    /**
     * Whether the Client has global access to every API, without being required to be specifically listed.
     *
     * @return bool Whether the Client has global access or not
     */
    public function hasGlobalAccess(): bool
    {
        return match ($this)
        {
            self::Developer => TRUE,
            default         => FALSE,
        };
    }

}

?>
