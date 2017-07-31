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
        if( null === static::$instance) {
            $container = new Container();
            $container->addServiceProvider(new RouteServiceProvider());
            static::$instance = $container;
        }
        return static::$instance;
    }

    /** @inheritdoc */
    private function __construct() {}

    /** @inheritdoc */
    private function __clone() {}

    /** @inheritdoc */
    private function __wakeup() {}
}