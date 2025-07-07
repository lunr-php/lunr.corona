<?php

/**
 * This file contains the RequestGuard class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona;

use BackedEnum;
use Lunr\Corona\Authorization\AuthorizationTypeInterface;
use Lunr\Corona\Authorization\AuthorizerInterface;
use Lunr\Corona\Exceptions\BadRequestException;
use Lunr\Corona\Exceptions\PreconditionFailedException;
use Lunr\Corona\Parsers\ApiVersion\ApiVersionInterface;
use Lunr\Corona\Parsers\ApiVersion\ApiVersionValue;
use RuntimeException;

/**
 * RequestGuard class.
 */
class RequestGuard
{

    /**
     * Shared instance of the Request class.
     * @var Request
     */
    protected readonly Request $request;

    /**
     * Map of registered authorizers.
     * @var array<string, AuthorizerInterface>
     */
    protected array $authorizers;

    /**
     * Constructor.
     *
     * @param Request $request Shared instance of the Request class
     */
    public function __construct(Request $request)
    {
        $this->request     = $request;
        $this->authorizers = [];
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->authorizers);
    }

    /**
     * Register an authorizer.
     *
     * @param AuthorizerInterface $authorizer The authorizer to register
     *
     * @return void
     */
    public function registerAuthorizer(AuthorizerInterface $authorizer): void
    {
        $this->authorizers[$authorizer->getAuthorizationType()->value] = $authorizer;
    }

    /**
     * Check Requirements for a webservice request.
     *
     * @param BackedEnum&ApiVersionInterface $version The minimum required API version for the webservice.
     *
     * @return void
     */
    public function validateApiVersion(BackedEnum&ApiVersionInterface $version): void
    {
        /**
         * @var (BackedEnum&ApiVersionInterface)|null $api
         */
        $api = $this->request->getAsEnum(ApiVersionValue::ApiVersion);

        if ($api === NULL)
        {
            $e = new BadRequestException('No API version specified!');

            $e->setData(ApiVersionValue::ApiVersion->value, NULL);

            throw $e;
        }

        if (!$api->isAtLeast($version))
        {
            throw new PreconditionFailedException('API version is no longer supported!');
        }
    }

    /**
     * Authorize the passed whitelist to access the resource.
     *
     * @param BackedEnum&AuthorizationTypeInterface $type       Type of authorization to use to verify the whitelist
     * @param string|BackedEnum                     ...$allowed Whitelist
     *
     * @return void
     */
    public function authorize(BackedEnum&AuthorizationTypeInterface $type, string|BackedEnum ...$allowed): void
    {
        if (!array_key_exists($type->value, $this->authorizers))
        {
            throw new RuntimeException('No authorizer registered for authorization type "' . $type->value . '"!');
        }

        $this->authorizers[$type->value]->authorize($allowed);
    }

}

?>
