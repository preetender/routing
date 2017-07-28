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
     * @return Route
     */
    public function get($path, $callable);

    /**
     * Routing POST call
     *
     * @param $path
     * @param $callable
     * @return Route
     */
    public function post($path, $callable);

    /**
     * Routing PUT call
     *
     * @param $path
     * @param $callable
     * @return Route
     */
    public function put($path, $callable);

    /**
     * Routing PATCH call
     *
     * @param $path
     * @param $callable
     * @return Route
     */
    public function patch($path, $callable);

    /**
     * Routing DELETE call
     *
     * @param $path
     * @param $callable
     * @return Route
     */
    public function delete($path, $callable);
}