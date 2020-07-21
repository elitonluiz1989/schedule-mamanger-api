<?php

namespace Tests\Unit\Core\Repositories;

use App\Models\Role;
use App\Repositories\BaseRepository;
use App\Repositories\RolesRepository;
use Tests\Helpers\RepositoryDataManipulationHelper;
use Tests\Helpers\RepositoryData;
use Tests\TestCase;

class RolesRepositoryTest extends TestCase
{
    use RepositoryDataManipulationHelper;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new RolesRepository();
        $this->repository->limit = 5;
        $this->repository->columns = ['id', 'name', 'type'];
        $this->model = new Role();
        $this->data = new RepositoryData();
        $this->data->create = [
            'name' => 'administrator',
            'type' => 1
        ];
        $this->data->update = [
            'name' => 'usertest',
            'type' => 999
        ];
    }

    /** @test */
    public function it_should_extend_the_base_repository_class(): void
    {
        $this->assertInstanceOf(BaseRepository::class, $this->repository);
    }
}
