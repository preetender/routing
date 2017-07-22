<?php

namespace Preetender\Routing;

/**
 * Interface RouterVerbs
 * @package Preetender\Routing
 */
interface RouterVerbs
{
    /**
     * Rotear requisição via GET
     *
     * @param $path
     * @param $callable
     * @return Route
     */
    public function get($path, $callable);

    /**
     * Rotear requisição via POST
     *
     * @param $path
     * @param $callable
     * @return Route
     */
    public function post($path, $callable);
}