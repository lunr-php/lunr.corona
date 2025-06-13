<?php

/**
 * This file contains a request value parser for static enum values
 *
 * SPDX-FileCopyrightText: Copyright 2025 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Generic;

use BackedEnum;
use Lunr\Corona\RequestEnumValueInterface;
use Lunr\Corona\RequestEnumValueParserInterface;
use Lunr\Corona\RequestValueInterface;
use RuntimeException;

/**
 * Request Value Parser for sapi
 */
class StaticEnumValueParser implements RequestEnumValueParserInterface
{

    /**
     * Request value key.
     * @var BackedEnum&RequestEnumValueInterface
     */
    protected readonly BackedEnum&RequestEnumValueInterface $key;

    /**
     * The static value to return.
     * @var BackedEnum|null
     */
    protected readonly ?BackedEnum $value;

    /**
     * Constructor.
     *
     * @param BackedEnum&RequestEnumValueInterface $key   Request value key
     * @param BackedEnum|null                      $value The static value to return
     */
    public function __construct(BackedEnum&RequestEnumValueInterface $key, ?BackedEnum $value)
    {
        $this->key   = $key;
        $this->value = $value;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        // no-op
    }

    /**
     * Return the request value type the parser handles.
     *
     * @return class-string The FQDN of the type enum the parser handles
     */
    public function getRequestValueType(): string
    {
        return $this->key::class;
    }

    /**
     * Get a request value.
     *
     * @param BackedEnum&RequestValueInterface $key The identifier/name of the request value to get
     *
     * @return string|null The requested value
     */
    public function get(BackedEnum&RequestValueInterface $key): ?string
    {
        return match ($key) {
            $this->key => ($this->value)?->value,
            default    => throw new RuntimeException('Unsupported request value type "' . $key::class . '"'),
        };
    }

    /**
     * Get a request value as an enum.
     *
     * @param BackedEnum&RequestEnumValueInterface $key The identifier/name of the request value to get
     *
     * @return ?BackedEnum The requested value
     */
    public function getAsEnum(BackedEnum&RequestEnumValueInterface $key): ?BackedEnum
    {
        return match ($key) {
            $this->key => $this->value,
            default    => throw new RuntimeException('Unsupported request value type "' . $key::class . '"'),
        };
    }

}

?>
