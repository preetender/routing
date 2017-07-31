<?php

namespace Preetender\Routing\Contracts;

use Preetender\Routing\Route;

/**
 * Interface RouterVerbs
 * @package Preetender\Routing
 */
interface RouterVerbs
{
    /**
     * Routing GET call
     *
     * @param $path
     * @param $callable
     * @param null $name
     * @return Route
     */
    public function get($path, $callable, $name = null);

    /**
     * Routing POST call
     *
     * @param $path
     * @param $callable
     * @param null $name
     * @return Route
     */
    public function post($path, $callable, $name = null);

    /**
     * Routing PUT call
     *
     * @param $path
     * @param $callable
     * @param null $name
     * @return Route
     */
    public function put($path, $callable, $name = null);

    /**
     * Routing PATCH call
     *
     * @param $path
     * @param $callable
     * @param null $name
     * @return Route
     */
    public function patch($path, $callable, $name = null);

    /**
     * Routing DELETE call
     *
     * @param $path
     * @param $callable
     * @param null $name
     * @return Route
     */
    public function delete($path, $callable, $name = null);
}