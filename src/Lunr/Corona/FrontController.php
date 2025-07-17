<?php

/**
 * This file contains the FrontController class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;
use RuntimeException;

/**
 * Controller class
 */
class FrontController
{

    /**
     * Shared instance of the Request class.
     * @var Request
     */
    protected readonly Request $request;

    /**
     * Shared instance of the RequestResultHandler class.
     * @var RequestResultHandler
     */
    protected readonly RequestResultHandler $handler;

    /**
     * Registered lookup paths.
     * @var array<string, string>
     */
    protected array $paths;

    /**
     * Registered routing rules.
     * @var array<string, string[]|null>
     */
    protected array $routes;

    /**
     * Constructor.
     *
     * @param Request              $request Instance of the Request class.
     * @param RequestResultHandler $handler Instance of the RequestResultHandler class.
     */
    public function __construct(Request $request, RequestResultHandler $handler)
    {
        $this->request = $request;
        $this->handler = $handler;

        $this->paths  = [];
        $this->routes = [];
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->paths);
        unset($this->routes);
    }

    /**
     * Register a path for controller lookup
     *
     * @deprecated Use registerLookupPath() instead
     *
     * @param string $identifier Path identifier
     * @param string $path       Path specification
     *
     * @return void
     */
    public function register_lookup_path(string $identifier, string $path): void
    {
        $this->registerLookupPath($identifier, $path);
    }

    /**
     * Register a path for controller lookup
     *
     * @param string $identifier Path identifier
     * @param string $path       Path specification
     *
     * @return void
     */
    public function registerLookupPath(string $identifier, string $path): void
    {
        $this->paths[$identifier] = $path;
    }

    /**
     * Add a static routing rule for specific calls.
     *
     * @deprecated Use addRoutingRule() instead
     *
     * @param string        $call  Request call identifier (either call or controller name)
     * @param string[]|null $route Routing rule. Use NULL for blacklisting, an empty array for whitelisting
     *                             or an array of path identifiers to limit the lookup search to those paths.
     *
     * @return void
     */
    public function add_routing_rule(string $call, ?array $route = []): void
    {
        $this->addRoutingRule($call, $route);
    }

    /**
     * Add a static routing rule for specific calls.
     *
     * @param string        $call  Request call identifier (either call or controller name)
     * @param string[]|null $route Routing rule. Use NULL for blacklisting, an empty array for whitelisting
     *                             or an array of path identifiers to limit the lookup search to those paths.
     *
     * @return void
     */
    public function addRoutingRule(string $call, ?array $route = []): void
    {
        $this->routes[$call] = $route;
    }

    /**
     * Get the controller responsible for the request.
     *
     * @deprecated Use getController() instead
     *
     * @param string   $src       Project subfolder to look for controllers in.
     * @param string[] $list      List of controller names
     * @param bool     $blacklist Whether to use the controller list as blacklist or whitelist
     *
     * @return string|null Fully qualified name of the responsible controller.
     */
    public function get_controller(string $src, array $list = [], bool $blacklist = TRUE): ?string
    {
        return $this->getController($src, $list, $blacklist);
    }

    /**
     * Get the controller responsible for the request.
     *
     * @param string   $src         Project subfolder to look for controllers in.
     * @param string[] $list        List of controller names
     * @param bool     $isBlacklist Whether to use the controller list as blacklist or whitelist
     *
     * @return string|null Fully qualified name of the responsible controller, or NULL if not found
     */
    public function getController(string $src, array $list = [], bool $isBlacklist = TRUE): ?string
    {
        $name = $this->request->controller . 'controller';

        if ($name == 'controller')
        {
            return NULL;
        }

        if (($isBlacklist === TRUE) && in_array($this->request->controller, $list))
        {
            return NULL;
        }

        if (($isBlacklist === FALSE) && !in_array($this->request->controller, $list))
        {
            return NULL;
        }

        if (!preg_match('/^[a-zA-Z0-9\-_]*$/', $name))
        {
            return NULL;
        }

        $name = str_replace('-', '', $name);

        $directory  = new RecursiveDirectoryIterator($src);
        $iterator   = new RecursiveIteratorIterator($directory);
        $candidates = new RegexIterator($iterator, "/^.+\/$name.php/i", RecursiveRegexIterator::GET_MATCH);

        $matches = array_keys(iterator_to_array($candidates));

        if (empty($matches) === TRUE)
        {
            return NULL;
        }

        if (count($matches) > 1)
        {
            throw new RuntimeException('Found multiple matching controllers!');
        }

        $search  = [ '.php', $src, '/' ];
        $replace = [ '', '', '\\' ];

        return ltrim(str_replace($search, $replace, $matches[0]), '\\');
    }

    /**
     * Lookup the controller in the registered paths.
     *
     * @param string ...$paths Identifiers for the paths to use for the lookup
     *
     * @return string|null Fully qualified name of the responsible controller, or NULL if not found.
     */
    public function lookup(string ...$paths): ?string
    {
        if (empty($this->paths))
        {
            return NULL;
        }

        $paths = empty($paths) ? array_keys($this->paths) : $paths;

        $controller = NULL;

        foreach ($paths as $id)
        {
            if (array_key_exists($id, $this->paths))
            {
                $controller = $this->getController($this->paths[$id]);
            }

            if ($controller != NULL)
            {
                break;
            }
        }

        return $controller;
    }

    /**
     * Find the controller name for the request made.
     *
     * @return string|null Fully qualified name of the responsible controller, or NULL if not found.
     */
    public function route(): ?string
    {
        foreach ([ 'call', 'controller' ] as $id)
        {
            $key = $this->request->$id;

            if (!array_key_exists($key, $this->routes))
            {
                continue;
            }

            if ($this->routes[$key] === NULL)
            {
                return NULL;
            }

            return $this->lookup(...$this->routes[$key]);
        }

        return $this->lookup();
    }

    /**
     * Dispatch to the found controller.
     *
     * @param object $controller Instance of the responsible Controller class.
     *
     * @return void
     */
    public function dispatch(object $controller): void
    {
        $callable = [ $controller, $this->request->method ];

        if (!is_callable($callable))
        {
            return;
        }

        $this->handler->handle_request($callable, $this->request->params);
    }

}

?>
