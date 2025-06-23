<?php

/**
 * This file contains the request value parser for the client version sourced from a cli argument.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\ClientVersion;

use BackedEnum;
use Lunr\Corona\RequestValueInterface;
use Lunr\Corona\RequestValueParserInterface;
use Lunr\Shadow\CliParserInterface;
use RuntimeException;

/**
 * Request Value Parser for the client version.
 *
 * @phpstan-import-type CliParameters from CliParserInterface
 */
class ClientVersionCliParser implements RequestValueParserInterface
{

    /**
     * Parser CLI argument AST.
     * @var CliParameters
     */
    protected readonly array $params;

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
     * Constructor.
     *
     * @param CliParameters $params Parsed CLI argument AST
     */
    public function __construct(array $params)
    {
        $this->params = $params;
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
        $token = NULL;

        if (array_key_exists('client-version', $this->params))
        {
            $token = $this->params['client-version'][0];
        }

        $this->clientVersion = $token;

        $this->clientVersionInitialized = TRUE;

        return $token;
    }

}

?>
