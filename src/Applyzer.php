<?php

namespace Sergiors\Applyzer;

use Sergiors\Applyzer\Exception\InvalidArgumentException;

/**
 * @author Sérgio Rafael Siqueira <sergio@inbep.com.br>
 */
class Applyzer implements ApplyzerInterface
{
    private function __construct()
    {
    }

    /**
     * @param array  $data
     * @param object $object
     */
    public static function apply(array $data, $object)
    {
        $that = new self();

        if (!is_object($object)) {
            throw new InvalidArgumentException('The second parameter must be an object.');
        }

        $data = $that->formalize($data);

        $reflObject = new \ReflectionObject($object);
        $reflMethods = $reflObject->getMethods(\ReflectionMethod::IS_PUBLIC);

        foreach ($reflMethods as $method) {
            $that->callMethod($object, $method, $data);
        }

        return $object;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    private function formalize(array $data)
    {
        return array_reduce(array_keys($data), function (array $prev, $attribute) use ($data) {
            return array_merge($prev, [
                $this->formatAttribute($attribute) => $data[$attribute]
            ]);
        }, []);
    }

    /**
     * @param object            $object
     * @param \ReflectionMethod $method
     * @param array             $data
     */
    private function callMethod($object, \ReflectionMethod $method, array $data)
    {
        if (!$this->isSetMethod($method)) {
            return;
        }

        $attribute = substr($method->name, 3);

        if (isset($data[$attribute])) {
            $method->invoke($object, $data[$attribute]);
        }
    }

    /**
     * @param string $attribute
     *
     * @return string
     */
    private function formatAttribute($attribute)
    {
        return preg_replace_callback(
            '/(^|_|\.)+(.)/',
            function ($match) {
                return ('.' === $match[1] ? '_' : '').strtoupper($match[2]);
            },
            $attribute
        );
    }

    /**
     * @param \ReflectionMethod $method
     *
     * @return bool
     */
    private function isSetMethod(\ReflectionMethod $method)
    {
        $methodLength = strlen($method->name);

        return (0 === strpos($method->name, 'set') && 3 < $methodLength)
                && 1 === $method->getNumberOfRequiredParameters();
    }
}
