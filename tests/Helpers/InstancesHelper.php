<?php

namespace Tests\Helpers;

trait InstancesHelper
{
    /**
     * Assert if the object have the passed method
     *
     * @param object $object
     * @param string $method
     * 
     * @return void
     */
    public function assertObjectHasMethod($object, string $method): void
    {
        $className = \get_class($object) . '::class';
        $message =  "Method '{$method}' does not exists in {$className}.";

        parent::assertTrue(\method_exists($this->repository, $method), $message);
    }
}