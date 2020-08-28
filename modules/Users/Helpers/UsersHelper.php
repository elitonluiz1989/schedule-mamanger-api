<?php

namespace Modules\Users\Helpers;

use Modules\Users\Models\User;

class UsersHelper
{
    /**
     * Return an array containing an User Permission data
     *
     * @param int $user_id
     * @return array
     */
    static function createPermissionData(int $user_id = 0): array
    {
        if ($user_id == 0) {
            $user_id = factory(User::class)->create()->first()->id;
        }

        return [
            'user_id' => $user_id,
            'create' => (bool)rand(0, 1),
            'read' => (bool)rand(0, 1),
            'update' => (bool)rand(0, 1),
            'delete' => (bool)rand(0, 1)
        ];
    }
}
