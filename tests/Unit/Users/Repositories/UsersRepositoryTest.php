<?php

namespace Tests\Unit\Users\Repositories;

use App\Models\Role;
use App\Modules\Users\Models\User;
use App\Modules\Users\Repositories\UsersRepository;
use App\Repositories\BaseRepository;
use Tests\TestCase;
use Tests\Unit\Helpers\RepositoryData;
use Tests\Unit\Helpers\RepositoryDataManipulationHelper;

class UsersRepositoryTest extends TestCase
{
    use RepositoryDataManipulationHelper;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new UsersRepository();
        $this->model = new User();
        $this->data = new RepositoryData([
            'create' => [
                'data' => [
                    'name' => 'User Test',
                    'password' => 'secret',
                    'avatar' => 'http://path-to-image/001.jpg',
                    'email' => 'usertest@test.com',
                    'role_id' => factory(Role::class)->create()->first()->id
                ],
                'exclude' => ['password']
            ],
            'update' => [
                'data' => [
                    'name' => 'Another User Test',
                    'password' => 'secret2',
                    'avatar' => 'http://path-to-image/002.jpg',
                    'email' => 'anotherusertest@test.com',
                    'role_id' => factory(Role::class)->create()->first()->id
                ],
                'exclude' => ['password']
            ]
        ]);
    }

    /** @test */
    public function it_should_extended_the_base_repository_class(): void
    {
        $this->assertInstanceOf(BaseRepository::class, $this->repository);
    }
}
