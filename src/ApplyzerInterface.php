<?php

namespace Sergiors\Applyzer;

/**
 * Defines the interface of applyzers.
 *
 * @author Sérgio Rafael Siqueira <sergio@inbep.com.br>
 */
interface ApplyzerInterface
{
    public static function apply(array $data, $object);
}
