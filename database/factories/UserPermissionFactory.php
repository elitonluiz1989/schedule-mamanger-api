<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use \App\Modules\Users\Helpers\UsersHelper;
use App\Modules\Users\Models\UserPermission;

$factory->define(UserPermission::class, function () {
    return UsersHelper::createPermissionData();
});
