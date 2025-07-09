<?php

/**
 * This file contains a request value parser for static string values
 *
 * SPDX-FileCopyrightText: Copyright 2025 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Generic;

use BackedEnum;
use Lunr\Corona\RequestValueInterface;
use Lunr\Corona\RequestValueParserInterface;
use RuntimeException;

/**
 * Request Value Parser for static strings
 */
class StaticStringValueParser implements RequestValueParserInterface
{

    /**
     * Request value key.
     * @var BackedEnum&RequestValueInterface
     */
    protected readonly BackedEnum&RequestValueInterface $key;

    /**
     * The static value to return.
     * @var string|null
     */
    protected readonly ?string $value;

    /**
     * Constructor.
     *
     * @param BackedEnum&RequestValueInterface $key   Request value key
     * @param string|null                      $value The static value to return
     */
    public function __construct(BackedEnum&RequestValueInterface $key, ?string $value)
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
            $this->key => $this->value,
            default    => throw new RuntimeException('Unsupported request value type "' . $key::class . '"'),
        };
    }

}

?>
