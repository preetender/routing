<?php

namespace Preetender\Routing;

use Preetender\Routing\Contracts\Renderable;

/**
 * Class RouteResponse
 * @package Preetender\Routing
 */
class RouteResponse implements Renderable
{
    /** @var */
    protected $data;

    /**
     * RouteResponse constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Format and return to requester
     *
     * @return mixed
     */
    public function render()
    {
        return $this->data;
    }
}