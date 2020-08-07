<?php

namespace App\Modules\Users\Models;

use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use YourAppRocks\EloquentUuid\Traits\HasUuid;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasUuid;

    protected $fillable = [
        'username', 'name', 'email', 'avatar', 'password', 'role_id'
    ];


    protected $hidden = [
        'id', 'password', 'api_token'
    ];

    /**
     * Set username attribute to lowercase
     *
     * @param string $value Value property
     * @return void
     */
    public function setUsernameAttribute(string $value): void
    {
        $this->attributes['username'] = strtolower($value);
    }

    /**
     * Encrypt user password
     *
     * @param string $value Value property
     * @return void
     */
    public function setPasswordAttribute(string $value): void
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Gets the user role relationship
     *
     * @return HasOne
     */
    public function role(): HasOne
    {
        return $this->hasOne(Role::class);
    }

    /**
     * Retrieve the user permission record
     *
     * @return BelongsTo
     */
    public function user_permissions(): BelongsTo
    {
        return $this->belongsTo(UserPermission::class);
    }
}
