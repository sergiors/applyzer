<?php
namespace Sergiors;

class Applyzer
{
    /**
     * @param array
     */
    private $data = [];

    /**
     * @param mixed $key
     * @param string [$value]
     */
    public function add($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $key => $value) {
                $this->add($key, $value);
            }

            return $this;
        }

        $this->data[$key] = $value;

        return $this;
    }

    public function apply(&$object)
    {
        if (!is_object($object)) {
            return false;
        }

        $reflectionObject = new \ReflectionObject($object);
        $reflectionMethods = $reflectionObject->getMethods(\ReflectionMethod::IS_PUBLIC);

        foreach ($reflectionMethods as $method) {
            if ($this->isSetMethod($method)) {
                $attribute = lcfirst(substr($method->name, 3));
                
                if (!isset($this->data[$attribute])) {
                    continue;
                }

                $method->invoke($object, $this->data[$attribute]);
            }
        }
        
        return $this;
    }

    /**
     * @param \ReflectionMethod $method
     * @return boolean
     */
    private function isSetMethod(\ReflectionMethod $method)
    {
        $methodLength = strlen($method->name);

        return (
            (0 === strpos($method->name, 'set') && 3 < $methodLength) &&
            1 === $method->getNumberOfRequiredParameters()
        );
    }
}

