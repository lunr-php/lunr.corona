<?php

/**
 * This file contains an authorizer using the client used to making the request.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Authorization\Client;

use BackedEnum;
use Lunr\Corona\Authorization\AuthorizationType;
use Lunr\Corona\Authorization\AuthorizationTypeInterface;
use Lunr\Corona\Authorization\AuthorizerInterface;
use Lunr\Corona\Exceptions\ForbiddenException;
use Lunr\Corona\Exceptions\UnauthorizedException;
use Lunr\Corona\Parsers\Client\ClientInterface;
use Lunr\Corona\Parsers\Client\ClientValue;
use Lunr\Corona\Request;

/**
 * Client based authorizer.
 */
class ClientAuthorizer implements AuthorizerInterface
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
        return AuthorizationType::Client;
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
        $client = $this->request->getAsEnum(ClientValue::Client);

        if (empty($allowed))
        {
            $exception = new ForbiddenException('Insufficient privileges to access resource!', 4030);

            $exception->setData('Client', $client?->value);

            throw $exception;
        }

        if ($client instanceof ClientInterface && $client->hasGlobalAccess())
        {
            return;
        }

        if (in_array($client, $allowed))
        {
            return;
        }

        if ($client === NULL)
        {
            throw new UnauthorizedException('Unauthorized access!', 4010);
        }

        if (in_array($client->value, $allowed))
        {
            return;
        }

        $exception = new ForbiddenException('Insufficient privileges to access resource!', 4030);

        $exception->setData('Client', $client->value);

        throw $exception;
    }

}

?>
