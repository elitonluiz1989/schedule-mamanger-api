<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Modules\Users\Helpers\UsersHelper;
use Modules\Users\Models\UserPermission;

$factory->define(UserPermission::class, function () {
    return UsersHelper::createPermissionData();
});
