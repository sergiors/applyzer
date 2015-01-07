<?php
namespace Sergiors\Applyzer;

use Sergiors\Applyzer\ApplyzerInterface;
use Sergiors\Applyzer\Exception\InvalidArgumentException;

/**
 * @author Sérgio Rafael Siqueira <sergiorsiqueira9@gmail.com>
 */
class Applyzer implements ApplyzerInterface
{
    /**
     * @param array $data
     * @param object $object
     */
    public function apply(array $data, $object)
    {
        if (!is_object($object)) {
            throw new InvalidArgumentException('Your second parameter must be an object.');
        }

        $reflectionObject = new \ReflectionObject($object);
        $reflectionMethods = $reflectionObject->getMethods(\ReflectionMethod::IS_PUBLIC);

        foreach ($reflectionMethods as $method) {
            $this->callMethod($object, $method, $data);
        }

        return $object;
    }

    /**
     * @param object $object
     * @param \ReflectionMethod $method
     * @param array $data
     */
    private function callMethod($object, \ReflectionMethod $method, array $data)
    {
        if (!$this->isSetMethod($method)) {
            return;
        }

        $attribute = lcfirst(substr($method->name, 3));

        if (isset($data[$attribute])) {
            $method->invoke($object, $data[$attribute]);
        }
    }

    /**
     * @param \ReflectionMethod $method
     * @return boolean
     */
    private function isSetMethod(\ReflectionMethod $method)
    {
        $methodLength = strlen($method->name);

        return (0 === strpos($method->name, 'set') && 3 < $methodLength) &&
               1 === $method->getNumberOfRequiredParameters();
    }
}

