<?php

/**
 * This file contains the request value parser for the route info.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\RouteInfo;

use BackedEnum;
use Lunr\Corona\RequestValueInterface;
use Lunr\Corona\RequestValueParserInterface;
use RuntimeException;

/**
 * Request Value Parser for route info.
 */
class RouteInfoParser implements RequestValueParserInterface
{

    /**
     * The parsed route group.
     * @var string
     */
    protected readonly string $group;

    /**
     * The parsed route name.
     * @var string
     */
    protected readonly string $name;

    /**
     * Constructor.
     *
     * @param string $defaultGroup Default route group
     * @param string $defaultName  Default route name
     */
    public function __construct(string $defaultGroup = 'general', string $defaultName = '/general/pre-routing')
    {
        $this->group = $defaultGroup;
        $this->name  = $defaultName;
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
        return RouteInfoValue::class;
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
        // Request ID is an alias for Trace ID
        return match ($key) {
            RouteInfoValue::Group => $this->group,
            RouteInfoValue::Name  => $this->name,
            default               => throw new RuntimeException('Unsupported request value type "' . $key::class . '"'),
        };
    }

}

?>
