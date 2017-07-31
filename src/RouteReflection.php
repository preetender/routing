<?php

namespace Preetender\Routing;
use League\Container\Exception\ContainerException;
use Preetender\Routing\Response\ExecuteResponse;

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
     * ...
     *
     * @return mixed
     */
    protected function handleRequestCallable()
    {
        static::createReflection(new \ReflectionFunction($this->getCallable()));
        $call = call_user_func_array($this->callable, static::resolveParameters());
        return ExecuteResponse::factory($call, $this->request, $this->response);
    }

    /**
     * ...
     *
     * @return mixed
     */
    protected function handleRequestController()
    {
        $attributes = RouteController::prepare($this->getCallable());
        static::createReflection(new \ReflectionClass($attributes['class']), $attributes['method']);
        $call = call_user_func_array([$attributes['class'], $attributes['method']], static::resolveParameters());
        return ExecuteResponse::factory($call, $this->request, $this->response);
    }

    /**
     * @param object $object
     * @param string|null $method
     */
    protected static function createReflection($object, string $method = null)
    {
        static::$reflectionObject = $object;
        static::$resolveMethodName = $method;
    }

    /**
     * @param int $position
     * @return mixed
     */
    protected static function getPointersAndReturnRequired(int $position)
    {
        return static::$parameters[ array_flip( static::$numberOfParameters)[$position] ];
    }

    /**
     * ...
     * @return array
     */
    protected static function resolveParameters()
    {
        $attributes = [];
        $parameters = static::getParametersObject();
        if(count($parameters) > 0) {
            foreach ($parameters as $parameter) {
                /** @var \ReflectionParameter $parameter */
                if(!$parameter->getClass()) {
                    static::$numberOfParameters[] = $parameter->getPosition();
                    $attributes[$parameter->getPosition()] = static::getPointersAndReturnRequired($parameter->getPosition());
                    continue;
                }
                $className = $parameter->getClass()->getName();
                if(static::checkClassRegisterContainer($className)) {
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
        if( static::$reflectionObject instanceof \ReflectionClass) {
            $method = static::$reflectionObject->getMethod( static::$resolveMethodName );
            return $method->getParameters();
        }
        if ( static::$reflectionObject instanceof \ReflectionFunction) {
            return static::$reflectionObject->getParameters();
        }
    }
}