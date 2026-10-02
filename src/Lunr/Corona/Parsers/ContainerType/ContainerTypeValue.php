<?php

/**
 * This file contains the container type request value.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\ContainerType;

use Lunr\Corona\RequestValueInterface;

/**
 * Request Data Enums
 */
enum ContainerTypeValue: string implements RequestValueInterface
{

    /**
     * Container type
     */
    case ContainerType = 'containerType';

}

?>
