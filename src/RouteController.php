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
     * @param $param
     * @return mixed
     */
    public static function format($param)
    {
        static::$param = explode('@', $param);
    }

    /**
     * Retorna namespace da classe
     *
     * @return string
     */
    public static function getClass() : string
    {
        return static::$param[0];
    }

    /**
     * Retorna nome do metodo
     *
     * @return string
     */
    public static function getMethod(): string
    {
        return static::$param[1];
    }
}