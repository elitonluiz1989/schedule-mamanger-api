<?php

namespace Modules\Users\Repositories;

use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Modules\Users\Models\UserPermission;

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
