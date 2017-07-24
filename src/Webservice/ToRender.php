<?php

namespace Preetender\Routing\Webservice;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ToRender
 * @package Preetender\Routing\Webservice
 */
abstract class ToRender implements Renderable
{
    /**
     * @var Renderable
     */
    protected $wrapped;

    /** @var array  */
    protected $headers = [];

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var Request
     */
    protected $request;

    /**
     * ToRender constructor.
     * @param Renderable $renderer
     * @param Request $request
     */
    public function __construct(Renderable $renderer, Request $request)
    {
        $this->wrapped = $renderer;

        $this->response = new Response();

        $this->request = $request;
    }
}