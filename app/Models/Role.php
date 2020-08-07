<?php

namespace App\Models;

use App\Helpers\Models\ModelAccessorHelper;
use Exception;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use ModelAccessorHelper;

    public $timestamps = false;

    protected $fillable = ['name', 'type'];

    /**
     * Verifies if the type values is valid
     *
     * @param $value
     * @throws \Exception
     */
    public function setTypeAttribute($value)
    {
        $roleTypes = config('common.roles.types');

        if (!in_array($value, $roleTypes)) {
            throw new Exception(trans('roles.type.invalid'));
        }

        $this->attributes['type'] = $value;
    }
}
