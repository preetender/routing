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

    /**
     * Rotear chamadas PUT
     *
     * @param $path
     * @param $callable
     * @return Route
     */
    public function put($path, $callable);


    /**
     * Rotear chamadas PATCH
     *
     * @param $path
     * @param $callable
     * @return Route
     */
    public function patch($path, $callable);


    /**
     * Rotear chamadas DELETE
     *
     * @param $path
     * @param $callable
     * @return Route
     */
    public function delete($path, $callable);
}