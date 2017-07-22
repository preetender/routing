<?php

namespace Preetender\Routing;

/**
 * Class Route
 * @package Preetender\Routing
 */
class Route
{
    /** @var string */
    protected $url;

    /**
     * @var
     */
    protected $callable;

    /**
     * @var array
     */
    private $matches = [];

    /**
     * Route constructor.
     * @param $url
     * @param $callable
     */
    public function __construct($url, $callable)
    {
        $this->url = trim($url, '/');
        $this->callable = $callable;
    }

    /**
     * Verifica path e cria parametros caso exista.
     *
     * @param $url
     * @return bool
     */
    public function match($url){
        $url = trim($url, '/');
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->getUrl());
        $regex = "#^$path$#i";
        if(!preg_match($regex, $url, $matches)){
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;
        return true;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getCallable()
    {
        return $this->callable;
    }

    /**
     * @return array
     */
    public function getMatches(): array
    {
        return $this->matches;
    }

    /**
     * Caso seja um controlador.
     *
     */
    private function prepareController()
    {
        $controller = explode('@', $this->getCallable());
        $class = $controller[0];
        $method = $controller[1];

        return call_user_func_array([$class, $method], $this->getMatches());
    }

    /**
     * Executa rota.
     *
     * @return mixed
     */
    public function run()
    {
        if( is_string( $this->getCallable() ) ) {
            return $this->prepareController();
        }

        if( is_callable( $this->getCallable() ) ) {
            return call_user_func_array($this->callable, $this->matches);
        }
    }

}