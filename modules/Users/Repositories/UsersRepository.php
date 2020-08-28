<?php

namespace Modules\Users\Repositories;

use App\Repositories\BaseRepository;
use Modules\Users\Models\User;

class UsersRepository extends BaseRepository
{
	public function __construct()
	{
		parent::__construct(new User());

		$this->columns = ['uuid', 'email', 'name', 'avatar', 'role_id', 'api_token'];
		$this->limit = 5;
	}
}
