<?php

namespace App\Modules\Users\Repositories;

use App\Modules\Users\Models\UserPermission;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class UserPermissionsRepository extends BaseRepository
{
	public function __construct()
	{
		parent::__construct(new UserPermission());

		$this->columns = ['id', 'user_id', 'create', 'read', 'update', 'delete'];
	}

    /**
     * Define all permissions to an passed user
     *
     * @param int $userId
     * @return Model
     */
	public function storeAllPermissions(int $userId): Model
    {
        return $this->store([
            'user_id' => $userId,
            'create' => true,
            'read' => true,
            'update' => true,
            'delete' => true
        ]);
    }
}
