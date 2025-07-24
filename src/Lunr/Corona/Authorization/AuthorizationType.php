<?php

/**
 * This file contains authorization types.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Authorization;

/**
 * Authorization Types.
 */
enum AuthorizationType: string implements AuthorizationTypeInterface
{

    /**
     * Authorization based on the client used to making the request.
     */
    case Client = 'Client';

}

?>
