<?php

/**
 * This file contains the request value parser for the host.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Host;

use BackedEnum;
use Lunr\Corona\RequestValueInterface;
use Lunr\Corona\RequestValueParserInterface;
use RuntimeException;

/**
 * Request Value Parser for the host.
 */
class HostParser implements RequestValueParserInterface
{

    /**
     * The parsed host value.
     * @var string|null
     */
    protected readonly ?string $host;

    /**
     * Whether the host value has been initialized or not.
     * @var true
     */
    protected readonly bool $hostInitialized;

    /**
     * Constructor.
     */
    public function __construct()
    {
        // no-op
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
        return HostValue::class;
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
            HostValue::Host => isset($this->hostInitialized) ? $this->host : $this->parse(),
            default         => throw new RuntimeException('Unsupported request value type "' . $key::class . '"'),
        };
    }

    /**
     * Parse the host value.
     *
     * @return string|null The parsed host
     */
    protected function parse(): ?string
    {
        $this->host = $_ENV['HOSTNAME'] ?? gethostname() ?: NULL;

        $this->hostInitialized = TRUE;

        return $this->host;
    }

}

?>
