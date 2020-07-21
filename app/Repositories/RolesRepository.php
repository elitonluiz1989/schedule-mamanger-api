<?php

namespace App\Repositories;

use App\Models\Role;

class RolesRepository extends BaseRepository
{
	public function __construct()
	{
		parent::__construct(new Role());

		$this->columns = ['id', 'name', 'type'];
	}
}
