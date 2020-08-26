<?php

namespace Tests\Unit\Core\Repositories;

use App\Repositories\BaseRepository;
use Tests\TestCase;
use Tests\Models\Core\TestSampleModel;
use Tests\Unit\Helpers\RepositoryData;
use Tests\Unit\Helpers\RepositoryDataManipulationHelper;
use Tests\Unit\Helpers\RepositoryTestHelper;

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
        $this->data->create->data = [
            'name' => 'test',
            'age' => 23
        ];
        $this->data->update->data = [
            'name' => 'tested',
            'age' => 12
        ];
    }
}
