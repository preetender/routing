<?php

namespace Preetender\Routing\Response;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Preetender\Routing\Contracts\Renderable;

/**
 * Class Formatter
 * @package Preetender\Routing\Response
 */
abstract class Formatter implements Renderable
{
    /** @var Renderable */
    protected $wrapped;

    /** @var array  */
    protected $headers = [];

    /** @var Response  */
    protected $response;

    /** @var Request */
    protected $request;

    /**
     * Formatter constructor.
     *
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