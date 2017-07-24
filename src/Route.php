<?php

namespace Preetender\Routing;

use Preetender\Routing\Webservice\JsonRenderer;
use Preetender\Routing\Webservice\TextPlainRenderer;
use Preetender\Routing\Webservice\Webservice;
use Symfony\Component\HttpFoundation\Request;

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
     * @var Request
     */
    protected $request;

    /**
     * @var string
     */
    protected $response_type;

    /** @var  */
    protected $execute;

    /**
     * Route constructor.
     * @param $url
     * @param $callable
     * @param string $response_type
     */
    public function __construct($url, $callable, $response_type = 'json')
    {
        $this->url = trim($url, '/');
        $this->callable = $callable;
        $this->request = Request::createFromGlobals();
        $this->response_type = $response_type;
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
     * Obtem url.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Obtem callback.
     *
     * @return mixed
     */
    public function getCallable()
    {
        return $this->callable;
    }

    /**
     * Obtem parametros.
     *
     * @return array
     */
    public function getMatches(): array
    {
        return array_merge($this->matches, [
            $this->request->query
        ]);
    }

    /**
     * Caso seja um controlador.
     *
     * @return mixed
     */
    private function prepareController()
    {
        $controller = explode('@', $this->getCallable());
        $class = $controller[0];
        $method = $controller[1];

        return call_user_func_array([$class, $method], $this->getMatches());
    }

    /**
     * Verifica tipo de chamada e solicita tratamento para a execução.
     *
     * @return mixed
     */
    public function run()
    {
        if( is_string( $this->getCallable() ) ) {
            $this->execute = $this->prepareController();
        }


        if( is_callable( $this->getCallable() ) ) {
            $this->execute = call_user_func_array($this->callable, $this->getMatches());
        }

        $this->formatAndRespond();
    }

    /**
     * Observa retorno e formata com auxilio da classe Webservice..
     *
     * @return mixed
     */
    protected function formatAndRespond()
    {
        $ws = new Webservice( $this->execute );

        $decorator = null;

        if( is_string( $this->execute) ) {
            $decorator = new TextPlainRenderer( $ws, $this->request);
        }

        if( is_array( $this->execute) ) {
            $decorator = new JsonRenderer( $ws, $this->request);
        }

        $decorator->render();
    }
}