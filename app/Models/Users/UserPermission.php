<?php

namespace App\Models\Users;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserPermission extends Model
{
    protected $fillable = ['user_id'];

    /**
     * @param $value
     * @throws Exception
     */
    public function setCreateAttribute($value): void
    {
        $this->handleAttributeValue('create', $value);
    }

    public function getCanCreateAttribute(): string
    {
        return $this->handleAttributesDisplay('create');
    }

    /**
     * @param $value
     * @throws Exception
     */
    public function setReadAttribute($value): void
    {
        $this->handleAttributeValue('read', $value);
    }

    public function getCanReadAttribute(): string
    {
        return $this->handleAttributesDisplay('read');
    }

    /**
     * @param $value
     * @throws Exception
     */
    public function setUpdateAttribute($value): void
    {
        $this->handleAttributeValue('update', $value);
    }

    public function getCanUpdateAttribute(): string
    {
        return $this->handleAttributesDisplay('update');
    }

    /**
     * @param $value
     * @throws Exception
     */
    public function setDeleteAttribute($value): void
    {
        $this->handleAttributeValue('delete', $value);
    }

    public function getCanDeleteAttribute(): string
    {
        return $this->handleAttributesDisplay('delete');
    }

    /**
     * Retrieve all related users
     *
     * @return HasMany
     */
    /*public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }*/

    /**
     * Verify if the attribute value is valid
     *
     * @param $attr
     * @param $value
     * @throws Exception
     */
    private function handleAttributeValue($attr, $value)
    {
        if (!is_bool($value)) {
            throw new Exception(trans('users.permission.invalid', ['property' => $attr, 'value' => $value]));
        }

        $boolVal = (bool)$value;
        $this->attributes[$attr] = $boolVal;
    }

    /**
     * Handle the value displayed form the boolean attributes
     *
     * @param $attr
     * @return string
     */
    private function handleAttributesDisplay($attr): string
    {
        $value = (bool)$this->attributes[$attr];

        if ($value) {
            return trans('common.binary.yes');
        }

        return trans('common.binary.no');
    }
}
