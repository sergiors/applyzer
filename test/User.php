<?php
namespace Sergiors\Applyzer;

class User
{
    private $name;
    
    private $lastName;
    
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getLastName()
    {
        return $this->lastName;
    }
}
