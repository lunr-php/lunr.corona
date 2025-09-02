<?php

/**
 * This file contains the RequestResultHandler.
 *
 * SPDX-FileCopyrightText: Copyright 2018 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona;

use BackedEnum;
use Lunr\Corona\Exceptions\ClientDataHttpException;
use Lunr\Corona\Exceptions\HttpException;
use Lunr\Ticks\EventLogging\EventLoggerInterface;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Throwable;

/**
 * RequestResultHandler.
 */
class RequestResultHandler
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
     * Shared instance of a Logger class.
     * @var LoggerInterface
     */
    protected readonly LoggerInterface $logger;

    /**
     * Shared instance of an EventLogger class
     * @var EventLoggerInterface
     */
    protected readonly EventLoggerInterface $eventLogger;

    /**
     * List of result codes to store analytics for, mapped to the measurement name they should be stored in.
     * @var array<int, string>
     */
    protected array $codeMap;

    /**
     * List of request values to add to analytics as tags.
     * @var array<string, BackedEnum&RequestValueInterface>
     */
    protected array $tagMap;

    /**
     * Constructor.
     *
     * @param Request         $request  Instance of the Request class.
     * @param Response        $response Instance of the Response class.
     * @param LoggerInterface $logger   Instance of a Logger class.
     */
    public function __construct(Request $request, Response $response, LoggerInterface $logger)
    {
        $this->request  = $request;
        $this->response = $response;
        $this->logger   = $logger;
        $this->codeMap  = [];
        $this->tagMap   = [];
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->codeMap);
        unset($this->tagMap);
    }

    /**
     * Enable request result analytics.
     *
     * @param EventLoggerInterface                            $eventLogger Instance of an event logger
     * @param array<int, string>                              $codeMap     List of result codes to store analytics for,
     *                                                                     mapped to the measurement name they should be stored in
     * @param array<string, BackedEnum&RequestValueInterface> $tagMap      List of request values to add to analytics as tags.
     *
     * @return void
     */
    public function enableAnalytics(
        EventLoggerInterface $eventLogger,
        array $codeMap,
        array $tagMap,
    ): void
    {
        $this->eventLogger = $eventLogger;
        $this->codeMap     = $codeMap;
        $this->tagMap      = $tagMap;
    }

    /**
     * Handle a request.
     *
     * @deprecated Use handleRequest() instead
     *
     * @param callable                 $callable Request handler to call
     * @param array<int|string, mixed> $params   Request parameters to pass to the callable
     *
     * @return void
     */
    public function handle_request(callable $callable, array $params)
    {
        $this->handleRequest($callable, $params);
    }

    /**
     * Handle a request.
     *
     * @param callable                 $callable Request handler to call
     * @param array<int|string, mixed> $params   Request parameters to pass to the callable
     *
     * @return void
     */
    public function handleRequest(callable $callable, array $params): void
    {
        try
        {
            call_user_func_array($callable, $params);
        }
        catch (HttpException $e)
        {
            $this->logRequestResult($e);

            $this->setResult($e->getCode(), $e->getMessage(), $e->getAppCode());
        }
        catch (Throwable $e)
        {
            $this->logger->error($e->getMessage(), [ 'exception' => $e ]);
            $this->setResult(HttpCode::INTERNAL_SERVER_ERROR, $e->getMessage());
        }

        // default to 200 if no result was set
        if ($this->response->hasCustomResultSet() === TRUE)
        {
            return;
        }

        $this->setResult(HttpCode::OK);
    }

    /**
     * Store result of the call in the response object.
     *
     * @param int         $code    Return Code
     * @param string|null $message Error Message
     * @param int|null    $info    Additional error information
     *
     * @return void
     */
    private function setResult(int $code, ?string $message = NULL, ?int $info = NULL): void
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

    /**
     * Log request results.
     *
     * @param HttpException $exception HTTP exception
     *
     * @return void
     */
    protected function logRequestResult(HttpException $exception): void
    {
        $code = $exception->getCode();

        if (!isset($this->codeMap[$code]))
        {
            return;
        }

        $fields = [
            'message' => $exception->getMessage(),
        ];

        $tags = [];

        foreach ($this->tagMap as $name => $key)
        {
            $value = $this->request->get($key);

            $tags[$name] = is_bool($value) ? $value : (string) $value;
        }

        if ($exception instanceof ClientDataHttpException)
        {
            if ($exception->isDataAvailable())
            {
                $tags['inputKey']     = $exception->getDataKey();
                $fields['inputValue'] = $exception->getDataValue();
            }

            if ($exception->isReportAvailable())
            {
                $fields['report'] = $exception->getReport();
            }
        }

        $event = $this->eventLogger->newEvent($this->codeMap[$code]);

        $event->recordTimestamp();
        $event->setTraceId($this->request->getTraceId() ?? throw new RuntimeException('Trace ID not available!'));
        $event->setSpanId($this->request->getSpanId() ?? throw new RuntimeException('Span ID not available!'));

        $parentSpanID = $this->request->getParentSpanId();

        if ($parentSpanID != NULL)
        {
            $event->setParentSpanId($parentSpanID);
        }

        $event->addTags(array_merge($this->request->getSpanSpecificTags(), $tags));
        $event->addFields($fields);
        $event->record();
    }

}

?>
