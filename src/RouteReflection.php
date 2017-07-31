<?php

namespace Preetender\Routing;

use League\Container\Exception\ContainerException;

/**
 * Trait RouteReflection
 * @package Preetender\Routing
 */
trait RouteReflection
{
    /** @var array */
    protected static $numberOfParameters = [];

    /** @var */
    protected static $reflectionObject;

    /** @var null  */
    protected static $resolveMethodName = null;

    /**
     * @param object $object
     * @param string|null $method
     */
    protected static function createReflection($object, string $method = null)
    {
        self::$reflectionObject = $object;
        if($method) {
            self::$resolveMethodName = $method;
        }
    }

    /**
     * @param int $position
     * @return int
     */
    protected static function getPointersAndReturnRequired(int $position)
    {
        return self::$parameters[ array_flip( self::$numberOfParameters)[$position] ];
    }

    /**
     * ...
     * @return array
     */
    protected static function resolveParameters()
    {
        $attributes = [];
        $parameters = self::getParametersObject();
        if(count($parameters) > 0) {
            foreach ($parameters as $parameter) {
                /** @var \ReflectionParameter $parameter */
                if(!$parameter->getClass()) {
                    self::$numberOfParameters[] = $parameter->getPosition();
                    $attributes[$parameter->getPosition()] = self::getPointersAndReturnRequired($parameter->getPosition());
                    continue;
                }
                $className = $parameter->getClass()->getName();
                if(self::checkClassRegisterContainer($className)) {
                    $attributes[$parameter->getPosition()] = Kernel::getContainer()->get($className);
                }
            }
        }
        return $attributes;
    }

    /**
     * Check whether injected class is registered in container.
     *
     * @param string $className
     * @return bool
     */
    protected static function checkClassRegisterContainer(string $className)
    {
        if(!Kernel::getContainer()->has($className)) {
            throw new ContainerException("Class [{$className}] not registered in the container.");
        }
        return true;
    }

    /**
     * Get all parameters to object
     *
     * @return mixed
     */
    protected static function getParametersObject()
    {
        if( self::$reflectionObject instanceof \ReflectionClass) {
            $method = self::$reflectionObject->getMethod(self::$resolveMethodName);
            return $method->getParameters();
        }
        if ( self::$reflectionObject instanceof \ReflectionFunction) {
            return self::$reflectionObject->getParameters();
        }
    }
}