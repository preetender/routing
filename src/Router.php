<?php

namespace Preetender\Routing;

use Preetender\Routing\Contracts\RouterVerbs;
use Preetender\Routing\Exceptions\MethodNotAllowedException;
use Preetender\Routing\Exceptions\UnregisteredRouteException;

/**
 * Class Route
 * @package Preetender\Routing
 */
class Router implements RouterVerbs
{
    /** @var array  */
    protected $routeStack = [];

    /**
     * Routing GET call
     *
     * @param $path
     * @param $callable
     * @return Route
     */
    public function get($path, $callable)
    {
        return $this->addRoute($path, $callable);
    }

    /**
     * Routing POST call
     *
     * @param $path
     * @param $callable
     * @return Route
     */
    public function post($path, $callable)
    {
        return $this->addRoute($path, $callable, 'POST');
    }

    /**
     * Routing PUT call
     *
     * @param $path
     * @param $callable
     * @return Route
     */
    public function put($path, $callable)
    {
        return $this->addRoute($path, $callable, 'PUT');
    }

    /**
     * Routing PATCH call
     *
     * @param $path
     * @param $callable
     * @return Route
     */
    public function patch($path, $callable)
    {
        return $this->addRoute($path, $callable, 'PATCH');
    }

    /**
     * Routing DELETE call
     *
     * @param $path
     * @param $callable
     * @return Route
     */
    public function delete($path, $callable)
    {
        return $this->addRoute($path, $callable, 'DELETE');
    }

    /**
     * Obtem metodo resiquisato.
     *
     * @return string
     */
    protected function method() : string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Get url request and delete queryString
     * @return string
     */
    protected function uri() : string
    {
        return strtok( $_SERVER['REQUEST_URI'], '?');
    }

    /**
     * Check if call contains png,jpg,jpeg,gif,css,js
     *
     * @return mixed
     */
    protected function hasRouteValid()
    {
        return preg_match('/\.(?:png|jpg|jpeg|gif|css|js)$/', $_SERVER["REQUEST_URI"]);
    }

    /**
     * To check for potential problems before running
     * @return bool
     * @throws MethodNotAllowedException
     */
    protected function checkCommonProblems()
    {
         if( static::hasRouteValid() ) {
            return false;
        }

        if( empty( $this->routeStack) )
        {
            throw new \InvalidArgumentException('Routing empty');
        }

        if( !isset( $this->routeStack[static::method()] ) ){
            throw new MethodNotAllowedException('Requested method was not scaled.');
        }
        return true;
    }

    /**
     * Register route
     *
     * @param $path
     * @param $callable
     * @param string $method
     * @return Route
     */
    protected function addRoute($path, $callable, $method = 'GET')
    {
        return $this->routeStack[$method][] = new Route($path, $callable);
    }

    /**
     * Obtain the requested method in the call and create the requested route.
     * @return mixed
     * @throws UnregisteredRouteException
     */
    protected function executeRoute()
    {
        foreach ($this->routeStack[static::method()] as $route) {
            /** @var $route Route */
            if( $route->match( $this->uri() ) ) {
                return $route->run();
            }
        }
        throw new UnregisteredRouteException('Unregistered route ');
    }

    /**
     * Execute
     *
     * @return bool|mixed
     * @throws MethodNotAllowedException
     */
    public function run()
    {
        $this->checkCommonProblems();

        return $this->executeRoute();
    }
}