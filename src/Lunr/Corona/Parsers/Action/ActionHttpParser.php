<?php

/**
 * This file contains the request value parser for the action sourced from the HTTP method used.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Action;

use BackedEnum;
use Lunr\Corona\ParsedEnumValueInterface;
use Lunr\Corona\RequestEnumValueInterface;
use Lunr\Corona\RequestEnumValueParserInterface;
use Lunr\Corona\RequestValueInterface;
use RuntimeException;

/**
 * Request Value Parser for the API version.
 */
class ActionHttpParser implements RequestEnumValueParserInterface
{

    /**
     * The parsed action value as enum.
     * @var (BackedEnum&ParsedEnumValueInterface)|null
     */
    protected readonly ?BackedEnum $action;

    /**
     * Whether the action value has been initialized or not.
     * @var true
     */
    protected readonly bool $actionInitialized;

    /**
     * The name of the enum to use for API version values.
     * @var class-string<BackedEnum&ParsedEnumValueInterface>
     */
    protected readonly string $enumName;

    /**
     * Constructor.
     *
     * @param class-string<BackedEnum&ParsedEnumValueInterface> $enumName The name of the enum to use for API version values.
     */
    public function __construct(string $enumName)
    {
        $this->enumName = $enumName;
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
        return ActionValue::class;
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
            ActionValue::Action => (isset($this->actionInitialized) ? $this->action : $this->parse())?->value,
            default             => throw new RuntimeException('Unsupported request value type "' . $key::class . '"'),
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
            ActionValue::Action => isset($this->actionInitialized) ? $this->action : $this->parse(),
            default             => throw new RuntimeException('Unsupported request value type "' . $key::class . '"'),
        };
    }

    /**
     * Parse the API version value from the HTTP authorization header.
     *
     * @return BackedEnum|null The parsed API version
     */
    protected function parse(): ?BackedEnum
    {
        $method = NULL;

        if (array_key_exists('REQUEST_METHOD', $_SERVER))
        {
            $method = $_SERVER['REQUEST_METHOD'];
        }

        $this->action = call_user_func_array([ $this->enumName, 'tryFromRequestValue' ], [ $method ]);

        $this->actionInitialized = TRUE;

        return $this->action;
    }

}

?>
