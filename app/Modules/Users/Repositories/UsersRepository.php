<?php

namespace App\Modules\Users\Repositories;

use App\Modules\Users\Models\User;
use App\Repositories\BaseRepository;

class UsersRepository extends BaseRepository
{
	public function __construct()
	{
		parent::__construct(new User());

		$this->columns = ['uuid', 'email', 'name', 'avatar', 'role_id', 'api_token'];
		$this->limit = 5;
	}
}
