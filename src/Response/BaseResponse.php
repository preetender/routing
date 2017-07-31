<?php

namespace Preetender\Routing\Response;

use Preetender\Routing\Contracts\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class BaseResponse
 * @package Preetender\Routing\Response
 */
abstract class BaseResponse implements Renderable
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
     * @param Response $response
     */
    public function __construct(Renderable $renderer, Request $request, Response $response)
    {
        $this->wrapped = $renderer;
        $this->request = $request;
        $this->response = $response;
    }
}