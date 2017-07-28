<?php

namespace Preetender\Routing;

use Preetender\Routing\Response\JsonRenderer;
use Preetender\Routing\Response\TextPlainRenderer;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Route
 * @package Preetender\Routing
 */
class Route
{
    /** @var string */
    protected $url;

    /** @var  */
    protected $callable;

    /** @var array  */
    private $params = [];

    /** @var Request  */
    protected $request;

    /** @var  */
    protected $execute;

    /**
     * Route constructor.
     * @param $url
     * @param $callable
     */
    public function __construct($url, $callable)
    {
        $this->url = trim($url, '/');
        $this->callable = $callable;
        $this->request = Request::createFromGlobals();
    }

    /**
     * Check the path, if there are parameters to create attributes for the scope of the request
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
        $this->params = $matches;
        return true;
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
    public function getParams(): array
    {
        return array_merge($this->params, [ $this->request ]);
    }

    /**
     * Prepares controller to be run
     *
     * @return mixed
     */
    private function prepareController()
    {
        RouteController::format( $this->getCallable() );
        return call_user_func_array( [ RouteController::getClass(), RouteController::getMethod()], $this->getParams() );
    }

    /**
     * Check the type of request and define which treatment it should receive
     *
     * @return mixed
     */
    public function run()
    {
        if( is_string( $this->getCallable() ) ) {
            $this->execute = $this->prepareController();
        }

        if( is_callable( $this->getCallable() ) ) {
            $this->execute = call_user_func_array( $this->callable, $this->getParams() );
        }

        return $this->formatAndRespond();
    }

    /**
     * Gets the lock return and returns with the due response
     *
     * @return mixed
     */
    protected function formatAndRespond()
    {
        $ws = new RouteResponse( $this->execute );

        $decorator = null;

        if( is_string( $this->execute) ) {
            $decorator = new TextPlainRenderer( $ws, $this->request);
        }

        if( is_array( $this->execute) ) {
            $decorator = new JsonRenderer( $ws, $this->request);
        }

        return $decorator->render();
    }
}