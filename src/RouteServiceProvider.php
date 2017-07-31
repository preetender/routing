<?php

namespace Preetender\Routing;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

/**
 * Class RouteServiceProvider
 * @package Preetender\Routing
 */
class RouteServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        Request::class,
        Response::class
    ];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     *
     * @return void
     */
    public function register()
    {
        $this->getContainer()->add(Request::class, Request::createFromGlobals());
        $this->getContainer()->add(Response::class, new Response());
    }
}