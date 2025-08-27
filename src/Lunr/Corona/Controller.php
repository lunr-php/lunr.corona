<?php

/**
 * This file contains an abstract controller class.
 *
 * SPDX-FileCopyrightText: Copyright 2010 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona;

use Lunr\Corona\Exceptions\NotImplementedException;

/**
 * Controller class
 *
 * @phpstan-type SuccessResult 100|101|102|200|201|202|203|204|205|206
 */
abstract class Controller
{

    /**
     * Shared instance of the Request class.
     * @var Request
     */
    protected readonly Request $request;

    /**
     * Shared instance of the Response class.
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
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        // no-op
    }

    /**
     * Handle unimplemented calls.
     *
     * @param string  $name      Method name
     * @param mixed[] $arguments Arguments passed to the method
     *
     * @return void
     */
    public function __call(string $name, array $arguments): void
    {
        throw new NotImplementedException();
    }

    /**
     * Store result of the call in the response object.
     *
     * @deprecated Use setResult() instead.
     *
     * @param SuccessResult $code    Return Code
     * @param string|null   $message Error Message
     * @param int|null      $info    Additional error information
     *
     * @return void
     */
    protected function set_result(int $code, ?string $message = NULL, ?int $info = NULL): void
    {
        $this->setResult($code, $message, $info);
    }

    /**
     * Store result of the call in the response object.
     *
     * @param SuccessResult $code    Return Code
     * @param string|null   $message Error Message
     * @param int|null      $info    Additional error information
     *
     * @return void
     */
    protected function setResult(int $code, ?string $message = NULL, ?int $info = NULL): void
    {
        $this->response->setResultCode($this->request->call, $code);

        if ($message !== NULL)
        {
            $this->response->setResultMessage($this->request->call, $message);
        }

        if ($info === NULL)
        {
            return;
        }

        $this->response->setResultInfoCode($this->request->call, $info);
    }

}

?>
