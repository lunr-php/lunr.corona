<?php

/**
 * This file contains the RouteInfoValue enum.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\RouteInfo;

use Lunr\Corona\RequestValueInterface;

/**
 * Enum for Route Info.
 */
enum RouteInfoValue: string implements RequestValueInterface
{

    /**
     * The group or family of a route the request belongs to.
     * For example, for a request /user/12345678/profile the group would be 'user'
     */
    case Group = 'group';

    /**
     * The named identifier of a route.
     */
    case Name = 'name';

}

?>
