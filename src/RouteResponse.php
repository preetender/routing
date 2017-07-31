<?php

namespace Preetender\Routing;

use Preetender\Routing\Contracts\Renderable;

/**
 * Class RouteResponse
 * @package Preetender\Routing
 */
final class RouteResponse implements Renderable
{
    /** @var */
    protected $data;

    /**
     * RouteResponse constructor.
     *
     * @param null $data
     */
    public function __construct($data = null)
    {
        $this->data = $data;
    }

    /**
     * Create static instance
     *
     * @param $data
     * @return static
     */
    public static function create($data)
    {
        return new static($data);
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