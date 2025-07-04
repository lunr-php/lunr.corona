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
 */
abstract class View
{

    /**
     * Shared instance of the Request class
     * @var Request
     */
    protected $request;

    /**
     * Shared instance of the Response class
     * @var Response
     */
    protected $response;

    /**
     * Constructor.
     *
     * @param Request  $request  Shared instance of the Request class
     * @param Response $response Shared instance of the Response class
     */
    public function __construct($request, $response)
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
        unset($this->request);
        unset($this->response);
    }

    /**
     * Build the actual display and print it.
     *
     * @return void
     */
    abstract public function print_page();

    /**
     * Build display for Fatal Error output.
     *
     * @return void
     */
    abstract public function print_fatal_error();

    /**
     * Build display for uncaught exception output.
     *
     * @param Throwable $e Uncaught exception
     *
     * @return void
     */
    abstract public function print_exception($e);

    /**
     * Return base_url or attach given path to base_url.
     *
     * @param string $path Path that should be attached to base_url (optional)
     *
     * @return string $return base_url (+ the given path, if given)
     */
    protected function base_url($path = '')
    {
        return $this->request->base_url . $path;
    }

    /**
     * Check whether the last error was fatal or not.
     *
     * @param array|null $error Value returned from error_get_last()
     *
     * @return bool $return TRUE if error was fatal, FALSE otherwise
     */
    protected function is_fatal_error($error)
    {
        if (($error === NULL) || !in_array($error['type'], [ E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR ]))
        {
            return FALSE;
        }

        return TRUE;
    }

}

?>
