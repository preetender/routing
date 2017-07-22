<?php

namespace Preetender\Routing;

/**
 * Class Route
 * @package Preetender\Routing
 */
class Router implements RouterVerbs
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var
     */
    protected $method;

    /**
     * @var array
     */
    protected $routes = [];

    /**
     * Router constructor.
     */
    public function __construct()
    {
        /** Remover querystring da URL */
        $this->url = strtok($_SERVER['REQUEST_URI'], '?');
    }

    /**
     * Obtem metodo resiquisato.
     *
     * @return string
     */
    protected static function method() : string { return $_SERVER['REQUEST_METHOD']; }

    /**
     * Rotear requisição via GET
     *
     * @param $path
     * @param $callable
     * @return Route
     */
    public function get($path, $callable)
    {
        $route = $this->register($path, $callable);
        return $route;
    }

    /**
     * Rotear requisição via POST
     *
     * @param $path
     * @param $callable
     * @return Route
     */
    public function post($path, $callable)
    {
        $route = $this->register($path, $callable, 'POST');
        return $route;
    }

    /**
     * Registrar rota.
     *
     * @param $path
     * @param $callable
     * @param string $method
     * @return Route
     */
    protected function register($path, $callable, $method = 'GET')
    {
        return $this->routes[$method][] = new Route($path, $callable);
    }

    /**
     * Verificar se solicitação é do tipo Arquivo..
     *
     * @return mixed
     */
    protected static function hasRouteValid()
    {
        return preg_match('/\.(?:png|jpg|jpeg|gif)$/', $_SERVER["REQUEST_URI"]);
    }

    /**
     * Obtem lista de rotas.
     *
     * @return array
     */
    public function getRoutes()
    {
        echo '<pre>';
        print_r( $this->routes  );
        echo '</pre>';
    }

    /**
     * Dispacha rota sinalizada na requisição.
     *
     * @return mixed
     */
    public function run()
    {

        if( static::hasRouteValid() ){
            return false;
        }

        if( !isset( $this->routes[static::method()] ) ){
            die('metodo não executavel');
        }

        foreach ($this->routes[static::method()] as $route) {
            /** @var $route Route */
            if( $route->match( $this->url) ){
                return $route->run();
            }
        }

        die('rota não identificada!');
    }
}