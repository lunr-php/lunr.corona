<?php

/**
 * This file contains the request action value.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Action;

use Lunr\Corona\RequestEnumValueInterface;

/**
 * Request Data Enums
 */
enum ActionValue: string implements RequestEnumValueInterface
{

    /**
     * API version
     */
    case Action = 'action';

}

?>
