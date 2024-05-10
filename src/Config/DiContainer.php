<?php

namespace App\Config;

use Closure;
use Exception;
use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;
use ReflectionParameter;
use function dd;

final class DiContainer
{
    /** @var array<string, string> $instances*/
    protected array $instances = [];

    public function set(string $abstract, ?string $concrete = null): void
    {
        if($concrete === null)
        {
            $concrete = $abstract;
        }
        $this->instances[$abstract] = $concrete;
    }

    /**
     * @throws ReflectionException
     */
    public function get(string $abstract, ReflectionParameter ...$parameter): mixed
    {
        if(!isset($this->instances[$abstract]))
        {
            $this->set($abstract);
        }

        return $this->resolve($this->instances[$abstract], ...$parameter);
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function resolve(mixed $concrete, ReflectionParameter ...$parameters): mixed
    {
        if($concrete instanceof Closure)
        {
            return $concrete($this, $parameters);
        }
        $reflector = new ReflectionClass($concrete);

        if(!$reflector->isInstantiable())
        {
            throw new Exception("class {$concrete} is not instantiable");
        }

        $constructor = $reflector->getConstructor();

        if($constructor === null)
        {
            return $reflector->newInstance();
        }

        $parameters = $constructor->getParameters();
        $dependencies = $this->getDependencies(...$parameters);

        return $reflector->newInstanceArgs($dependencies);

    }

    /**
     * @throws ReflectionException
     */
    public function getDependencies(ReflectionParameter ...$parameters): mixed
    {
        $dependencies = [];
        foreach ($parameters as $parameter)
        {
            $dependency = $parameter->getType();

            if($dependency === null)
            {
                if($parameter->isDefaultValueAvailable())
                {
                    $dependencies[] = $parameter->getDefaultValue();
                }
                else
                {
                    throw new Exception("Cant resolve {$parameter->getName()}");
                }
            }
            else
            {
                $dependencies[] = $this->get($dependency->getName());
            }
        }

        return $dependencies;
    }
}