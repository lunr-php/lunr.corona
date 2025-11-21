<?php

/**
 * This file contains a html view class.
 *
 * SPDX-FileCopyrightText: Copyright 2010 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona;

use Lunr\Core\Configuration;
use Lunr\Corona\Parsers\Url\UrlValue;

/**
 * View class used by the Website
 */
abstract class HTMLView extends View
{

    /**
     * Configuration values
     * @var array<array-key, mixed>|Configuration
     */
    protected readonly array|Configuration $config;

    /**
     * List of javascript files to include.
     * @var string[]
     */
    protected array $javascript;

    /**
     * List of stylesheets to include.
     * @var string[]
     */
    protected array $stylesheets;

    /**
     * Constructor.
     *
     * @param Request                               $request  Shared instance of the Request class
     * @param Response                              $response Shared instance of the Response class
     * @param array<array-key, mixed>|Configuration $config   Configuration values
     */
    public function __construct(Request $request, Response $response, array|Configuration $config)
    {
        parent::__construct($request, $response);

        $this->config      = $config;
        $this->javascript  = [];
        $this->stylesheets = [];
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();

        unset($this->javascript);
        unset($this->stylesheets);
    }

    /**
     * Return path to statics or attach given path to it.
     *
     * @param string $path Path that should be attached to the statics path
     *                     (optional)
     *
     * @return string $return path to statics (+ the given path, if given)
     */
    protected function statics($path = '')
    {
        $output  = '';
        $base    = '/' . trim($this->request->get(UrlValue::BasePath) ?? '', '/');
        $statics = '/' . trim($this->config['path']['statics'], '/');
        $path    = '/' . trim($path, '/');

        if ($base != '/')
        {
            $output .= $base;
        }

        if ($statics != '/')
        {
            $output .= $statics;
        }

        $output .= $path;
        return $output;
    }

    /**
     * Generate css include statements.
     *
     * @param bool $sort Whether to sort the list of css files or not
     *
     * @return string $links Generated html code for including css stylesheets
     */
    protected function includeStylesheets(bool $sort = FALSE): string
    {
        $links = '';

        if ($sort === TRUE)
        {
            sort($this->stylesheets);
        }

        foreach ($this->stylesheets as $stylesheet)
        {
            if (!$this->isExternal($stylesheet))
            {
                $basePath    = str_replace($this->request->get(UrlValue::BasePath) ?? '', '', $stylesheet);
                $stylesheet .= '?' . filemtime($this->request->application_path . $basePath);
            }

            $links .= '<link rel="stylesheet" type="text/css" href="' . $stylesheet . '">' . "\n";
        }

        return $links;
    }

    /**
     * Generate javascript include statements.
     *
     * @param bool $sort Whether to sort the list of js files or not
     *
     * @return string $links Generated html code for including javascript
     */
    protected function includeJavascript(bool $sort = FALSE): string
    {
        $links = '';

        if ($sort === TRUE)
        {
            sort($this->javascript);
        }

        foreach ($this->javascript as $js)
        {
            if (!$this->isExternal($js))
            {
                $basePath = str_replace($this->request->get(UrlValue::BasePath) ?? '', '', $js);
                $js      .= '?' . filemtime($this->request->application_path . $basePath);
            }

            $links .= '<script src="' . $js . '"></script>' . "\n";
        }

        return $links;
    }

    /**
     * Check of a URI is external or local
     *
     * @param string $uri A URI
     *
     * @return bool if the URI is external or not
     */
    private function isExternal(string $uri): bool
    {
        return (strpos($uri, 'http://') === 0 || strpos($uri, 'https://') === 0 || strpos($uri, '//') === 0);
    }

    /**
     * Return an alternating (eg. odd/even) CSS class name.
     *
     * @param string $basename        CSS base class name (without
     *                                ending underscore or suffix)
     * @param int    $alternationHint Integer counter indicating the
     *                                alternation state
     * @param string $suffix          An alternative suffix if you
     *                                don't want odd/even
     *
     * @return string $return The constructed CSS class name
     */
    protected function cssAlternate(string $basename, int $alternationHint, string $suffix = ''): string
    {
        if ($suffix == '')
        {
            if ($alternationHint % 2 == 0)
            {
                $basename .= '_even';
            }
            else
            {
                $basename .= '_odd';
            }
        }
        else
        {
            $basename .= '_' . $suffix;
        }

        return $basename;
    }

}

?>
