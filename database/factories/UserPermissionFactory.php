<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Helpers\UsersHelper;
use App\Models\Users\UserPermission;

$factory->define(UserPermission::class, function () {
    return UsersHelper::createPermissionData();
});
