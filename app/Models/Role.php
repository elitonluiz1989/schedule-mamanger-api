<?php

namespace App\Models;

use App\Helpers\Models\ModelAccessorHelper;
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
        $roleTypes = [1, 999];//config('common.roles.types');

        if (!\in_array($value, $roleTypes)) {
            throw new \Exception(trans('common.roles.types.invalid'));
        }

        $this->attributes['type'] = $value;
    }
}
