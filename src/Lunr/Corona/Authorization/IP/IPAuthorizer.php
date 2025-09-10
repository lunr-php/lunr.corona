<?php

/**
 * This file contains an authorizer using the IP used to making the request.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Authorization\IP;

use BackedEnum;
use Lunr\Corona\Authorization\AuthorizationType;
use Lunr\Corona\Authorization\AuthorizationTypeInterface;
use Lunr\Corona\Authorization\AuthorizerInterface;
use Lunr\Corona\Exceptions\ForbiddenException;
use Lunr\Corona\Request;

/**
 * IP based authorizer.
 */
class IPAuthorizer implements AuthorizerInterface
{

    /**
     * Shared instance of the Request class.
     * @var Request
     */
    protected readonly Request $request;

    /**
     * Constructor.
     *
     * @param Request $request Shared instance of the Request class
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        // no-op
    }

    /**
     * Get the authorization type the authorizer supports.
     *
     * @return BackedEnum&AuthorizationTypeInterface The supported authorization type
     */
    public function getAuthorizationType(): BackedEnum&AuthorizationTypeInterface
    {
        return AuthorizationType::IP;
    }

    /**
     * Authorize a request.
     *
     * @param list<string|BackedEnum> $allowed Whitelist
     *
     * @return void
     */
    public function authorize(array $allowed): void
    {
        $ip = $this->request->getHttpHeaderData('X-Forwarded-For') ?? $this->request->getServerData('REMOTE_ADDR');

        if (empty($allowed))
        {
            $exception = new ForbiddenException('IP not whitelisted to access resource!', 4031);

            $exception->setData('IP', $ip);

            throw $exception;
        }

        $ips = array_map('trim', explode(',', $ip));

        $result = array_intersect($ips, $allowed);

        if ($result === [])
        {
            $exception = new ForbiddenException('IP not whitelisted to access resource!', 4031);

            $exception->setData('IP', $ip);

            throw $exception;
        }
    }

}

?>
