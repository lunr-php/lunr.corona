<?php

/**
 * This file contains the request value parser for the URL
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Url;

use BackedEnum;
use Lunr\Corona\RequestValueInterface;
use Lunr\Corona\RequestValueParserInterface;
use RuntimeException;

/**
 * Request Value Parser for sapi
 */
class UrlParser implements RequestValueParserInterface
{

    /**
     * The URL path.
     * @var string|null
     */
    protected readonly ?string $basePath;

    /**
     * Whether the basePath value has been initialized or not.
     * @var true
     */
    protected readonly bool $basePathInitialized;

    /**
     * The base URL.
     * @var string|null
     */
    protected readonly ?string $baseUrl;

    /**
     * Whether the baseUrl value has been initialized or not.
     * @var true
     */
    protected readonly bool $baseUrlInitialized;

    /**
     * The URL domain.
     * @var string|null
     */
    protected readonly ?string $domain;

    /**
     * Whether the domain value has been initialized or not.
     * @var true
     */
    protected readonly bool $domainInitialized;

    /**
     * The URL port.
     * @var string|null
     */
    protected readonly ?string $port;

    /**
     * Whether the port value has been initialized or not.
     * @var true
     */
    protected readonly bool $portInitialized;

    /**
     * The URL protocol.
     * @var string|null
     */
    protected readonly ?string $protocol;

    /**
     * Whether the protocol value has been initialized or not.
     * @var true
     */
    protected readonly bool $protocolInitialized;

    /**
     * Name of the file serving as entry point.
     * @var string
     */
    protected readonly string $entryPoint;

    /**
     * Constructor.
     *
     * @param string $entryPoint Name of the file serving as entry point (index.php by default)
     */
    public function __construct(string $entryPoint = 'index.php')
    {
        $this->entryPoint = $entryPoint;
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
        return UrlValue::class;
    }

    /**
     * Get a request value.
     *
     * @param BackedEnum&RequestValueInterface $key The identifier/name of the request value to get
     *
     * @return string|null
     */
    public function get(BackedEnum&RequestValueInterface $key): ?string
    {
        return match ($key) {
            UrlValue::Protocol => isset($this->protocolInitialized) ? $this->protocol : $this->parseProtocol(),
            UrlValue::Domain   => isset($this->domainInitialized) ? $this->domain : $this->parseDomain(),
            UrlValue::Port     => isset($this->portInitialized) ? $this->port : $this->parsePort(),
            UrlValue::BasePath => isset($this->basePathInitialized) ? $this->basePath : $this->parseBasePath(),
            UrlValue::BaseUrl  => isset($this->baseUrlInitialized) ? $this->baseUrl : $this->parseBaseUrl(),
            default            => throw new RuntimeException('Unsupported request value type "' . $key::class . '"'),
        };
    }

    /**
     * Parse the URL protocol.
     *
     * @return string|null The parsed protocol
     */
    protected function parseProtocol(): ?string
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']))
        {
            $this->protocol = $_SERVER['HTTP_X_FORWARDED_PROTO'];
        }
        else
        {
            $this->protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http';
        }

        $this->protocolInitialized = TRUE;

        return $this->protocol;
    }

    /**
     * Parse the URL domain.
     *
     * @return string|null The parsed domain
     */
    protected function parseDomain(): ?string
    {
        $this->domain = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? NULL;

        $this->domainInitialized = TRUE;

        return $this->domain;
    }

    /**
     * Parse the URL port.
     *
     * @return string|null The parsed port
     */
    protected function parsePort(): ?string
    {
        $this->port = $_SERVER['SERVER_PORT'] ?? NULL;

        $this->portInitialized = TRUE;

        return $this->port;
    }

    /**
     * Parse the URL path.
     *
     * @return string|null The parsed path
     */
    protected function parseBasePath(): ?string
    {
        $this->basePath = isset($_SERVER['SCRIPT_NAME']) ? str_replace($this->entryPoint, '', $_SERVER['SCRIPT_NAME']) : NULL;

        $this->basePathInitialized = TRUE;

        return $this->basePath;
    }

    /**
     * Parse the base URL.
     *
     * @return string|null The parsed base URL
     */
    protected function parseBaseUrl(): ?string
    {
        $protocol = isset($this->protocolInitialized) ? $this->protocol : $this->parseProtocol();
        $port     = isset($this->portInitialized) ? $this->port : $this->parsePort();
        $domain   = isset($this->domainInitialized) ? $this->domain : $this->parseDomain();
        $path     = isset($this->basePathInitialized) ? $this->basePath : $this->parseBasePath();

        $baseUrl = NULL;

        if ($domain !== NULL)
        {
            $baseUrl .= $domain;

            if ($protocol !== NULL)
            {
                $baseUrl = $protocol . '://' . $baseUrl;
            }

            if ($port !== NULL && ((($protocol == 'http') && ($port != 80)) || (($protocol == 'https') && ($port != 443)) || $protocol === NULL))
            {
                $baseUrl .= ':' . $port;
            }
        }

        if ($path !== NULL)
        {
            $this->baseUrl = $baseUrl . $path;
        }
        else
        {
            $this->baseUrl = $baseUrl . '/';
        }

        $this->baseUrlInitialized = TRUE;

        return $this->baseUrl;
    }

}

?>
