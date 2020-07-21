<?php

namespace App\Helpers\Models;

trait ModelAccessorHelper
{
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }
}
