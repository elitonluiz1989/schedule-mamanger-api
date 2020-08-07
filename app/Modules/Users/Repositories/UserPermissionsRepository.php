<?php

namespace App\Modules\Users\Repositories;

use App\Modules\Users\Models\UserPermission;
use App\Repositories\BaseRepository;

class UserPermissionsRepository extends BaseRepository
{
	public function __construct()
	{
		parent::__construct(new UserPermission());

		$this->columns = ['id', 'user_id', 'create', 'read', 'update', 'delete'];
	}
}
