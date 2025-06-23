<?php

/**
 * This file contains the request value parser for the client version sourced from HTTP authorization headers.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\ClientVersion;

use BackedEnum;
use Lunr\Corona\RequestValueInterface;
use Lunr\Corona\RequestValueParserInterface;
use RuntimeException;

/**
 * Request Value Parser for the client version.
 */
class ClientVersionHttpHeaderParser implements RequestValueParserInterface
{

    /**
     * The parsed clientVersion value.
     * @var string|null
     */
    protected readonly ?string $clientVersion;

    /**
     * Whether the clientVersion value has been initialized or not.
     * @var true
     */
    protected readonly bool $clientVersionInitialized;

    /**
     * The name of the HTTP header holding the client version info
     * @var string
     */
    protected readonly string $header;

    /**
     * Constructor.
     *
     * @param non-empty-string $header The name of the HTTP header holding the API version.
     */
    public function __construct(string $header = 'Client-Version')
    {
        $this->header = 'HTTP_' . str_replace('-', '_', strtoupper($header));
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
        return ClientVersionValue::class;
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
            ClientVersionValue::ClientVersion => isset($this->clientVersionInitialized) ? $this->clientVersion : $this->parse(),
            default                           => throw new RuntimeException('Unsupported request value type "' . $key::class . '"'),
        };
    }

    /**
     * Parse the client version value from the HTTP authorization header.
     *
     * @return string|null The parsed client version
     */
    protected function parse(): ?string
    {
        $version = NULL;

        if (array_key_exists($this->header, $_SERVER))
        {
            $version = $_SERVER[$this->header];
        }

        $this->clientVersion = $version;

        $this->clientVersionInitialized = TRUE;

        return $version;
    }

}

?>
