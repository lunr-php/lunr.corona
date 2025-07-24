<?php

/**
 * This file contains the request analytics value.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Analytics;

use Lunr\Corona\RequestValueInterface;

/**
 * Request Data Enums
 */
enum AnalyticsValue: string implements RequestValueInterface
{

    /**
     * API version
     */
    case AnalyticsEnabled = 'analyticsEnabled';

}

?>
