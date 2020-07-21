<?php

namespace Tests\Unit\Core\Repositories;

use App\Repositories\BaseRepository;
use Tests\Helpers\RepositoryData;
use Tests\Helpers\RepositoryDataManipulationHelper;
use Tests\Helpers\RepositoryTestHelper;
use Tests\TestCase;
use Tests\Models\Core\TestSampleModel;

class BaseRepositoryTest extends TestCase
{
    use RepositoryTestHelper, RepositoryDataManipulationHelper;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = new BaseRepository(new TestSampleModel());
        $this->repository->limit = 5;
        $this->repository->columns = ['id', 'name', 'age'];
        $this->model = new TestSampleModel();
        $this->data = new RepositoryData();
        $this->data->create = [
            'name' => 'test',
            'age' => 23
        ];
        $this->data->update = [
            'name' => 'tested',
            'age' => 12
        ];
    }
}
