<?php

/**
 * This file contains the request value parser for analytics enablement sourced from a cli argument.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Analytics;

use BackedEnum;
use Lunr\Corona\RequestValueInterface;
use Lunr\Corona\RequestValueParserInterface;
use Lunr\Shadow\CliParserInterface;
use RuntimeException;

/**
 * Request Value Parser for analytics enablement.
 *
 * @phpstan-import-type CliParameters from CliParserInterface
 */
class AnalyticsCliParser implements RequestValueParserInterface
{

    /**
     * Parser CLI argument AST.
     * @var CliParameters
     */
    protected readonly array $params;

    /**
     * The parsed analytics value.
     * @var bool
     */
    protected readonly bool $analytics;

    /**
     * The default status of analytics enablement.
     * @var bool
     */
    protected readonly bool $analyticsDefault;

    /**
     * Constructor.
     *
     * @param CliParameters $params           Parsed CLI argument AST
     * @param bool          $analyticsEnabled Default state in case when no CLI argument is passed (disabled, by default)
     */
    public function __construct(array $params, bool $analyticsEnabled = FALSE)
    {
        $this->params           = $params;
        $this->analyticsDefault = $analyticsEnabled;
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
        return AnalyticsValue::class;
    }

    /**
     * Get a request value.
     *
     * @param BackedEnum&RequestValueInterface $key The identifier/name of the request value to get
     *
     * @return bool The requested value
     */
    public function get(BackedEnum&RequestValueInterface $key): bool
    {
        return match ($key) {
            AnalyticsValue::AnalyticsEnabled => $this->analytics ?? $this->parse(),
            default                          => throw new RuntimeException('Unsupported request value type "' . $key::class . '"'),
        };
    }

    /**
     * Parse analytics enablement information from a CLI argument.
     *
     * @return bool The parsed value
     */
    protected function parse(): bool
    {
        $value = $this->analyticsDefault;

        if (array_key_exists('analytics', $this->params))
        {
            $value = match (strtolower($this->params['analytics'][0])) {
                'on',
                'yes',
                'enabled' => TRUE,
                default   => FALSE,
            };
        }

        $this->analytics = $value;

        return $this->analytics;
    }

}

?>
