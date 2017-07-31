<?php

namespace Preetender\Routing;

/**
 * Class RouteController
 * @package Preetender\Routing
 */
class RouteController
{
    /** @var array  */
    protected static $param = [];

    /**
     * Format string and split into layers
     * @param $param
     * @return mixed
     */
    public static function format($param)
    {
        static::$param = explode('@', $param);
    }

    /**
     * Return class name
     *
     * @return string
     */
    public static function getClass() : string
    {
        return static::$param[0];
    }

    /**
     * Retorna method name
     *
     * @return string
     */
    public static function getMethod(): string
    {
        return static::$param[1];
    }

    /**
     * @param $param
     * @return array
     */
    public static function prepare($param)
    {
        $format = static::format($param);
        return [
            'class' => RouteController::getClass(),
            'method' => RouteController::getMethod()
        ];
    }
}
