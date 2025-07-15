<?php

/**
 * This file contains a view class.
 *
 * SPDX-FileCopyrightText: Copyright 2010 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona;

use Lunr\Corona\Parsers\TracingInfo\TracingInfoValue;
use Throwable;

/**
 * View class used by the Website
 *
 * @phpstan-type LastError array{
 *     type: int,
 *     message: string,
 *     file: string,
 *     line: int,
 * }
 */
abstract class View
{

    /**
     * Shared instance of the Request class
     * @var Request
     */
    protected readonly Request $request;

    /**
     * Shared instance of the Response class
     * @var Response
     */
    protected readonly Response $response;

    /**
     * Constructor.
     *
     * @param Request  $request  Shared instance of the Request class
     * @param Response $response Shared instance of the Response class
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request  = $request;
        $this->response = $response;

        if (headers_sent())
        {
            return;
        }

        header('X-Request-ID: ' . $request->get(TracingInfoValue::TraceID));
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        // no-op
    }

    /**
     * Build the actual display and print it.
     *
     * @deprecated Use printPage() instead
     *
     * @return void
     */
    public function print_page(): void
    {
        $this->printPage();
    }

    /**
     * Build the actual display and print it.
     *
     * @return void
     */
    abstract public function printPage(): void;

    /**
     * Build display for Fatal Error output.
     *
     * @deprecated Use printFatalError() instead
     *
     * @return void
     */
    public function print_fatal_error(): void
    {
        $this->printFatalError();
    }

    /**
     * Build display for Fatal Error output.
     *
     * @return void
     */
    abstract public function printFatalError(): void;

    /**
     * Build display for uncaught exception output.
     *
     * @deprecated Use printException() instead
     *
     * @param Throwable $e Uncaught exception
     *
     * @return void
     */
    public function print_exception(Throwable $e): void
    {
        $this->printException($e);
    }

    /**
     * Build display for uncaught exception output.
     *
     * @param Throwable $e Uncaught exception
     *
     * @return void
     */
    abstract public function printException(Throwable $e): void;

    /**
     * Return base_url or attach given path to base_url.
     *
     * @param string $path Path that should be attached to base_url (optional)
     *
     * @return string base_url (+ the given path, if given)
     */
    protected function baseUrl(string $path = ''): string
    {
        return $this->request->base_url . $path;
    }

    /**
     * Check whether the last error was fatal or not.
     *
     * @param LastError|null $error Value returned from error_get_last()
     *
     * @return bool TRUE if error was fatal, FALSE otherwise
     */
    protected function isFatalError(?array $error): bool
    {
        if (($error === NULL) || !in_array($error['type'], [ E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR ]))
        {
            return FALSE;
        }

        return TRUE;
    }

}

?>
