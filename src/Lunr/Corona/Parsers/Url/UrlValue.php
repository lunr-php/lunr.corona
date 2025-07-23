<?php

/**
 * This file contains the sapi value.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\Url;

use Lunr\Corona\RequestValueInterface;

/**
 * Request Data Enums
 */
enum UrlValue: string implements RequestValueInterface
{

    /**
     * The protocol used for the request.
     */
    case Protocol = 'protocol';

    /**
     * The domain used for the request.
     */
    case Domain = 'domain';

    /**
     * The port used for the request.
     */
    case Port = 'port';

    /**
     * The base path of the application.
     */
    case BasePath = 'basePath';

    /**
     * Protocol, domain, port and base path combined.
     */
    case BaseUrl = 'baseUrl';

}

?>
