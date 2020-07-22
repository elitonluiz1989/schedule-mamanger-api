<?php

namespace Tests\Helpers;

use App\Contracts\Repositories\RepositoryContract;
use Illuminate\Database\Eloquent\Model;

class RepositoryData
{
    public array $create;

    public array $update;
}

trait RepositoryDataManipulationHelper
{
    protected RepositoryContract $repository;

    private Model $model;

    private RepositoryData $data;

    /** @test */
    public function it_should_can_list_the_model_data_paginated(): void
    {
        $amountRecords = $this->getAmountOfRecords();
        $modelClass = $this->getModelClass();
        factory($modelClass, $amountRecords)->create();

        $data = $this->repository->all();
        $item = $data->first();

        $this->assertEquals($amountRecords, $data->total());
        $this->assertCount($this->repository->limit, $data);
        $this->assertInstanceOf($modelClass, $item);

        foreach ($this->repository->columns as $column) {
            $this->assertNotEquals($item->$column, null, "The data returned does not have the '$column' column.");
        }
    }

    /** @test */
    public function it_should_can_get_a_specific_model_item(): void
    {
        $amountRecords = $this->getAmountOfRecords();
        $modelClass = $this->getModelClass();
        factory($modelClass, $amountRecords)->create();

        $id = rand(1, $amountRecords);
        $data = $this->repository->find(['id' => $id]);

        $this->assertCount(1, $data);

        $item = $data->first();
        $this->assertInstanceOf($modelClass, $item);
        $this->assertEquals($item->id, $id, "The data returned is not have the same value by 'id'.");
    }

    /** @test */
    public function it_should_be_able_create_a_model_item(): void
    {;
        $item = $this->repository->store($this->data->create);

        $this->assertInstanceOf($this->getModelClass(), $item);

        foreach ($this->data->create as $key => $value) {
            $this->assertEquals($item->$key, $value);
        }
    }

    /** @test */
    public function it_should_to_able_update_a_model_item(): void
    {
        $modelClass = $this->getModelClass();
        $item = factory($modelClass)->create($this->data->create);

        $data = array_merge(['id' => $item->id], $this->data->update);
        $itemUpdated = $this->repository->store($data);

        $this->assertInstanceOf($modelClass, $itemUpdated);
        $this->assertEquals($itemUpdated->id, $item->id, "The data returned is not have the same value by 'id'.");

        foreach ($this->data->update as $key => $value) {
            $this->assertEquals($itemUpdated->$key, $value);
        }
    }

    /** @test */
    public function it_should_to_able_remove_a_model_item(): void
    {
        $item = factory($this->getModelClass())->create($this->data->create);

        $isDeleted = $this->repository->remove(['id' => $item->id]);
        $itemDeleted = $this->model->find($item->id);

        $this->assertIsBool($isDeleted);
        $this->assertEquals($itemDeleted, null);
    }

    /**
     * Return the string definition of model class
     *
     * @return string
     */
    private function getModelClass(): string
    {
        return get_class($this->model);
    }

    /**
     * Return the amount of records used to create data by factories
     *
     * @return int
     */
    private function getAmountOfRecords(): int
    {
        $amount = $this->repository->limit * rand(2, 3);
        $amount += ($amount / rand(1, 9));
        $amount = (int)ceil($amount);

        return $amount;
    }
}
