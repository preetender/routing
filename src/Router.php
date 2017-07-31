<?php

namespace Preetender\Routing;

use Illuminate\Http\Response;
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

    /** @var array  */
    protected $routesGroupByName = [];

    /**
     * Routing GET call
     *
     * @param $path
     * @param $callable
     * @param null $name
     * @return Route
     */
    public function get($path, $callable, $name = null)
    {
        return $this->addRoute($path, $callable, 'GET', $name);
    }

    /**
     * Routing POST call
     *
     * @param $path
     * @param $callable
     * @param null $name
     * @return Route
     */
    public function post($path, $callable, $name = null)
    {
        return $this->addRoute($path, $callable, 'POST', $name);
    }

    /**
     * Routing PUT call
     *
     * @param $path
     * @param $callable
     * @param null $name
     * @return Route
     */
    public function put($path, $callable, $name = null)
    {
        return $this->addRoute($path, $callable, 'PUT', $name);
    }

    /**
     * Routing PATCH call
     *
     * @param $path
     * @param $callable
     * @param null $name
     * @return Route
     */
    public function patch($path, $callable, $name = null)
    {
        return $this->addRoute($path, $callable, 'PATCH', $name);
    }

    /**
     * Routing DELETE call
     *
     * @param $path
     * @param $callable
     * @param null $name
     * @return Route
     */
    public function delete($path, $callable, $name = null)
    {
        return $this->addRoute($path, $callable, 'DELETE', $name);
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
        return trim(strtok( $_SERVER['REQUEST_URI'], '?'), '/');
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
        if(self::hasRouteValid()) {
            return false;
        }
        if(empty( $this->routeStack)) {
            throw new \InvalidArgumentException('Routing empty');
        }
        if(!isset($this->routeStack[self::method()])) {
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
     * @param null $name
     * @return Route
     */
    protected function addRoute($path, $callable, $method = 'GET', $name = null)
    {
        $route = new Route($path, $callable);
        $this->routeStack[$method][] = $route;
        if($name) {
            $this->routesGroupByName[$name] = $route;
        }
        return $route;
    }

    /**
     * Obtain the requested method in the call and create the requested route.
     * @return mixed
     * @throws UnregisteredRouteException
     */
    protected function executeRoute()
    {
        foreach ($this->routeStack[self::method()] as $key => $route) {
            /** @var $route Route */
            if($route->extractParameters(self::uri())) {
                return $route->run();
            }
        }
        throw new UnregisteredRouteException('Unregistered route ');
    }

    /**
     * ... go to route by name
     *
     * @param $name
     * @param array $params
     * @return mixed
     * @throws UnregisteredRouteException
     */
    public function goUrl($name, $params = [])
    {
        if(!isset($this->routesGroupByName[$name])) {
            throw new UnregisteredRouteException('Unregistered route by name ' . $name);
        }
        /** @var Route $route */
        $route = $this->routesGroupByName[$name];
        return $route->requestUrlCall($params);
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