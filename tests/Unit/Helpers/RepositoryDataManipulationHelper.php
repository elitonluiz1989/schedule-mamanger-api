<?php

namespace Tests\Unit\Helpers;

use App\Contracts\Repositories\RepositoryContract;
use Illuminate\Database\Eloquent\Model;

class RepositoryDataItem
{
    public array $data = [];

    public array $exclude = [];

    /**
     * Retrieve the recorded items on data
     * If there're items to be excluded, they'll be removed
     *
     * @return array
     */
    public function items(): array
    {
        if (!empty($this->exclude)) {
            return array_filter($this->data, function($key) {
                return !in_array($key, $this->exclude);
            }, ARRAY_FILTER_USE_KEY);
        }

        return $this->data;
    }
}

class RepositoryData
{
    public RepositoryDataItem $create;

    public RepositoryDataItem $update;

    public function __construct(array $data = [])
    {
        $this->create = new RepositoryDataItem();
        $this->update = new RepositoryDataItem();

        foreach ($data as $dataItem => $dataItemContent) {
            if (property_exists($this, $dataItem)) {
                foreach ($dataItemContent as $dataItemProp => $dataItemPropValue) {
                    if (property_exists($this->$dataItem, $dataItemProp)) {
                        $this->$dataItem->$dataItemProp = $dataItemPropValue;
                    }
                }
            }
        }
    }
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
        if ($this->repository->limit > 0) {
            $this->assertCount($this->repository->limit, $data);
        }
        $this->assertInstanceOf($modelClass, $item);

        if (!empty($this->repository->columns)) {
            foreach ($this->repository->columns as $column) {
                $this->assertNotEquals($item->$column, null, "The data returned does not have the '$column' column.");
            }
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

        $item = $data->first();

        $this->assertCount(1, $data);
        $this->assertInstanceOf($modelClass, $item);

        // Validation for case where id is a model hidden property
        if (null != $item->id) {
            $this->assertEquals($item->id, $id, "The data returned is not have the same value by 'id'.");
        }
    }

    /** @test */
    public function it_should_be_able_create_a_model_item(): void
    {;
        $item = $this->repository->store($this->data->create->data);

        $this->assertInstanceOf($this->getModelClass(), $item);

        foreach ($this->data->create->items() as $key => $value) {
            $this->assertEquals($item->$key, $value);
        }
    }

    /** @test */
    public function it_should_to_able_update_a_model_item(): void
    {
        $modelClass = $this->getModelClass();
        $item = factory($modelClass)->create($this->data->create->data);

        $data = array_merge(['id' => $item->id], $this->data->update->data);
        $itemUpdated = $this->repository->store($data);

        $this->assertInstanceOf($modelClass, $itemUpdated);
        if (null != $item->id) {
            $this->assertEquals($itemUpdated->id, $item->id, "The data returned is not have the same value by 'id'.");
        }

        foreach ($this->data->update->items() as $key => $value) {
            $this->assertEquals($itemUpdated->$key, $value);
        }
    }

    /** @test */
    public function it_should_to_able_remove_a_model_item(): void
    {
        $item = factory($this->getModelClass())->create($this->data->create->data);

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
        $limit = $this->repository->limit;

        if ($limit == 0) {
            $limit = 12;
        }

        $amount = $limit * rand(2, 3);
        $amount += ($amount / rand(1, 9));
        $amount = (int)ceil($amount);

        return $amount;
    }
}
