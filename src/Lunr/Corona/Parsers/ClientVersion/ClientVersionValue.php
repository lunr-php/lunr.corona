<?php

/**
 * This file contains the client version request value.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\ClientVersion;

use Lunr\Corona\RequestValueInterface;

/**
 * Request Data Enums
 */
enum ClientVersionValue: string implements RequestValueInterface
{

    /**
     * API version
     */
    case ClientVersion = 'clientVersion';

}

?>
