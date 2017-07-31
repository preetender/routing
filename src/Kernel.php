<?php

namespace Preetender\Routing;

use League\Container\Container;

/**
 * Class Kernel
 * @package Preetender\Routing
 */
final class Kernel
{
    /** @var  Container */
    private static $instance;

    /**
     * Get container service
     *
     * @return Container
     */
    public static function getContainer(): Container
    {
        if( null === self::$instance) {
            $container = new Container();
            $container->addServiceProvider(new RouteServiceProvider());
            self::$instance = $container;
        }
        return self::$instance;
    }
}