<?php

/**
 * This file contains the request value parser for the container type.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\ContainerType;

use BackedEnum;
use Lunr\Corona\RequestValueInterface;
use Lunr\Corona\RequestValueParserInterface;
use RuntimeException;

/**
 * Request Value Parser for the container type.
 */
class ContainerTypeParser implements RequestValueParserInterface
{

    /**
     * The parsed container type value.
     * @var string
     */
    protected readonly string $containerType;

    /**
     * Whether the container type value has been initialized or not.
     * @var true
     */
    protected readonly bool $containerTypeInitialized;

    /**
     * The default container type.
     * @var string
     */
    protected readonly string $defaultType;

    /**
     * The name of the environment variable holding the container type.
     * @var string
     */
    protected readonly string $envVar;

    /**
     * Constructor.
     *
     * @param non-empty-string $defaultType The default container type
     * @param non-empty-string $envVar      The name of the environment variable holding the container type
     */
    public function __construct(string $defaultType = 'unknown', string $envVar = 'CONTAINER_TYPE')
    {
        $this->defaultType = $defaultType;
        $this->envVar      = $envVar;
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
        return ContainerTypeValue::class;
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
            ContainerTypeValue::ContainerType => isset($this->containerTypeInitialized) ? $this->containerType : $this->parse(),
            default                           => throw new RuntimeException('Unsupported request value type "' . $key::class . '"'),
        };
    }

    /**
     * Parse the container type value.
     *
     * @return string The parsed container type
     */
    protected function parse(): string
    {
        $value = $_ENV[$this->envVar] ?? '';

        $this->containerType = $value !== '' ? $value : $this->defaultType;

        $this->containerTypeInitialized = TRUE;

        return $this->containerType;
    }

}

?>
