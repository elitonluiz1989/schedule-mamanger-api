<?php

namespace Tests\Unit\Users\Repositories;

use App\Modules\Users\Helpers\UsersHelper;
use App\Modules\Users\Models\UserPermission;
use App\Modules\Users\Repositories\UserPermissionsRepository;
use App\Repositories\BaseRepository;
use Exception;
use Tests\Helpers\RepositoryData;
use Tests\Helpers\RepositoryDataManipulationHelper;
use Tests\TestCase;

class UserPermissionsRepositoryTest extends TestCase
{
    use RepositoryDataManipulationHelper;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new UserPermissionsRepository();
        $this->model = new UserPermission();
        $this->data = new RepositoryData([
            'create' => [
                'data' => UsersHelper::createPermissionData()
            ],
            'update' => [
                'data' => UsersHelper::createPermissionData()
            ]
        ]);
    }

    /** @test */
    public function it_should_extended_the_base_repository_class(): void
    {
        $this->assertInstanceOf(BaseRepository::class, $this->repository);
    }

    /** @test */
    public function it_should_not_able_insert_a_invalid_value_to_create_permission(): void
    {
        $data = UsersHelper::createPermissionData();
        $data['create'] = 'd';

        $this->expectException(Exception::class);
        $this->expectExceptionMessage(trans('users.permission.invalid', ['property' => 'create', 'value' => $data['create']]));
        $this->repository->store($data);


    }

    /** @test */
    public function it_should_not_able_insert_a_invalid_value_to_read_permission(): void
    {
        $data = UsersHelper::createPermissionData();
        $data['read'] = 1;

        $this->expectException(Exception::class);
        $this->expectExceptionMessage(trans('users.permission.invalid', ['property' => 'read', 'value' => $data['read']]));
        $this->repository->store($data);
    }

    /** @test */
    public function it_should_not_able_insert_a_invalid_value_to_update_permission(): void
    {
        $data = UsersHelper::createPermissionData();
        $data['update'] = [];

        $this->expectException(Exception::class);
        $this->expectExceptionMessage(trans('users.permission.invalid', ['property' => 'update', 'value' => $data['update']]));
        $this->repository->store($data);
    }

    /** @test */
    public function it_should_not_able_insert_a_invalid_value_to_delete_permission(): void
    {
        $data = UsersHelper::createPermissionData();
        $data['delete'] = 0;

        $this->expectException(Exception::class);
        $this->expectExceptionMessage(trans('users.permission.invalid', ['property' => 'delete', 'value' => $data['delete']]));
        $this->repository->store($data);
    }
}
