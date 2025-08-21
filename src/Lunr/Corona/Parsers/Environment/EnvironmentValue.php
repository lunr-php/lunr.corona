<?php

/**
 * This file contains the environment request value.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Environment;

use Lunr\Corona\RequestEnumValueInterface;

/**
 * Request Data Enums
 */
enum EnvironmentValue: string implements RequestEnumValueInterface
{

    /**
     * API version
     */
    case Environment = 'environment';

}

?>
