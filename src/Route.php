<?php

namespace Preetender\Routing;

use Illuminate\Http\Response;
use Illuminate\Http\Request;

/**
 * Class Route
 * @package Preetender\Routing
 */
class Route
{
    use RouteReflection;

    /** @var string */
    protected $url;

    /** @var  */
    protected $callable;

    /** @var   */
    protected $name;

    /** @var array  */
    private static $parameters = [];

    /** @var array  */
    private static $attributes = [];

    /** @var Request  */
    protected $request;

    /** @var  Response */
    protected $response;

    /** @var  */
    protected $running;

    /**
     * Route constructor.
     * @param $url
     * @param $callable
     * @param null $name
     */
    public function __construct($url, $callable, $name = null)
    {
        $this->url = trim($url, '/');
        $this->callable = $callable;
        $this->request = Kernel::getContainer()->get(Request::class);
        $this->response = Kernel::getContainer()->get(Response::class);
        $this->name = $name;
    }

    /**
     * Check the path, if there are parameters to create attributes for the scope of the request
     *
     * @param $url
     * @return bool
     */
    public function extractParameters($url)
    {
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'attributesMatch'], $this->getUrl());
        if(!preg_match("#^$path$#i", $url, $matches)) {
            return false;
        }
        array_shift($matches);
        static::$parameters = $matches;
        return true;
    }

    /**
     * ...
     *
     * @param $match
     * @return string
     */
    private function attributesMatch($match) {
        if(isset(static::$attributes[$match[1]])) {
            return '(' . static::$attributes[$match[1]] . ')';
        }
        return '([^/]+)';
    }

    /**
     * Get url.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Get name route
     *
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get callback.
     *
     * @return mixed
     */
    public function getCallable()
    {
        return $this->callable;
    }

    /**
     * Get params.
     *
     * @return array
     */
    public static function getParameters(): array
    {
        return static::$parameters;
    }

    /**
     * Get properties on route
     *
     * @return array
     */
    public function getRoute()
    {
        return [
           'name' => $this->getName(),
           'path' => $this->getUrl(),
           'callable' => $this->getCallable(),
           'parameters' => static::resolveParameters()
        ];
    }

    /**
     * Executing route
     *
     * @param array $parameters
     * @return mixed
     */
    public function requestUrlCall($parameters = [])
    {
        $path = $this->getUrl();
        foreach ($parameters as $key => $value) {
            $path = str_replace(":$key", $value, $path);
        }
        $this->extractParameters($path);
        return $this->run();
    }

    /**
     * Exporta para o controlador uma coleção de dados;
     *
     * @param string $attribute
     * @param string $regex
     * @return $this
     */
    public function with(string $attribute, string $regex)
    {
        static::$attributes[$attribute] = str_replace('(', '(?:', $regex);
        return $this;
    }

    /**
     * Check the type of request and define which treatment it should receive
     *
     * @return mixed
     */
    public function run()
    {
        if(is_string($this->getCallable())) {
            return  $this->handleRequestController();
        }
        return $this->handleRequestCallable();
    }
}