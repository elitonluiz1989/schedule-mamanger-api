<?php

namespace App\Repositories\Users;

use App\Models\Users\User;
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
