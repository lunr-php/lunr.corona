<?php

/**
 * This file contains the host request value.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Host;

use Lunr\Corona\RequestValueInterface;

/**
 * Request Data Enums
 */
enum HostValue: string implements RequestValueInterface
{

    /**
     * Host name
     */
    case Host = 'host';

}

?>
