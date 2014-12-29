<?php
namespace Sergiors\Applyzer;

/**
 * Defines the interface of applyzers
 *
 * @author Sérgio Rafael Siqueira <sergiorsiqueira9@gmail.com>
 */
interface ApplyzerInterface
{
    public function apply(array $data, $object);
}