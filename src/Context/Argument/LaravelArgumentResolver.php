<?php

namespace Cevinio\Behat\Context\Argument;

use Cevinio\Behat\ServiceContainer\LaravelFactory;
use ReflectionClass;
use Behat\Behat\Context\Argument\ArgumentResolver;

final class LaravelArgumentResolver implements ArgumentResolver
{
    /** @var LaravelFactory */
    private $factory;

    public function __construct(LaravelFactory $factory)
    {
        $this->factory = $factory;
    }

    public function resolveArguments(ReflectionClass $classReflection, array $arguments)
    {
        $app = $this->factory->get();

        return array_map(function ($argument) use ($app) {
            if (true === is_string($argument) && '' !== $argument && '@' === $argument[0]) {
                return $app->make(substr($argument, 1));
            }

            return $argument;
        }, $arguments);
    }
}
