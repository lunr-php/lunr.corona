<?php

/**
 * This file contains the interface for authorizers.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Authorization;

use BackedEnum;

/**
 * Authorizer Interface.
 */
interface AuthorizerInterface
{

    /**
     * Get the authorization type the authorizer supports.
     *
     * @return BackedEnum&AuthorizationTypeInterface The supported authorization type
     */
    public function getAuthorizationType(): BackedEnum&AuthorizationTypeInterface;

    /**
     * Authorize a request.
     *
     * @param list<string|BackedEnum> $allowed Whitelist
     *
     * @return void
     */
    public function authorize(array $allowed): void;

}

?>
