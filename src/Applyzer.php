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
            throw new InvalidArgumentException('The second parameter must be an object');
        }
        
        $data = $this->formalize($data);
        
        $reflectionObject = new \ReflectionObject($object);
        $reflectionMethods = $reflectionObject->getMethods(\ReflectionMethod::IS_PUBLIC);

        foreach ($reflectionMethods as $method) {
            $this->callMethod($object, $method, $data);
        }

        return $object;
    }
    
    /**
     * @param array $data
     * @return array
     */
    private function formalize(array $data)
    {
        $formalized = [];
    
        foreach ($data as $attribute => $value) {
            $attribute = $this->formatAttribute($attribute);
            $formalized[$attribute] = $value;
        }
        
        return $formalized;
    }

    /**
     * @param object $object
     * @param \ReflectionMethod $method
     * @param array $data
     */
    private function callMethod($object, \ReflectionMethod $method, array $data)
    {
        if (!$this->isSetMethod($method)) {
            return null;
        }
        
        $attribute = substr($method->name, 3);

        if (isset($data[$attribute])) {
            $method->invoke($object, $data[$attribute]);
        }
    }
    
    /**
     * @param string $attribute
     * @return string
     */
    private function formatAttribute($attribute)
    {
        return preg_replace_callback('/(^|_|\.)+(.)/', function ($match) {
                return ('.' === $match[1] ? '_' : '').strtoupper($match[2]);
            }, $attribute
        );

        return $attribute;
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

