<?php

namespace Tests\Unit\Helpers;

use Exception;

trait RepositoryTestHelper
{
    /** @test */
    public function it_should_have_the_set_method_defined()
    {
        $this->assertObjectHasMethod($this->repository, '__set');
    }

    /** @test */
    public function it_should_have_the_get_method_defined()
    {
        $this->assertObjectHasMethod($this->repository, '__get');
    }

    /** @test */
    public function it_should_have_page_property_defined()
    {
        $this->repository->page = 2;
        $this->assertIsInt($this->repository->page);
        $this->assertEquals($this->repository->page, 2);
    }

    /** @test */
    public function it_should_not_be_able_set_an_wrong_value_to_page_property()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(trans('common.object.type.int', ['property' => 'page']));
        $this->repository->page = 'a';
    }

    /** @test */
    public function it_should_not_be_able_set_a_nonpositive_value_to_page_property()
    {
        $this->repository->page = 0;
        $this->assertEquals($this->repository->page, 1, 'The expected value was 1 but received 0.');
        $this->repository->page = -235;
        $this->assertEquals($this->repository->page, 1, 'The expected value was 1 but received -235.');
    }

    /** @test */
    public function it_should_have_limit_property_defined()
    {
        $this->repository->limit = 10;
        $this->assertIsInt($this->repository->limit);
        $this->assertEquals($this->repository->limit, 10);
    }

    /** @test */
    public function it_should_not_be_able_set_an_wrong_value_to_limit_property()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(trans('common.object.type.int', ['property' => 'limit']));
        $this->repository->limit = 'apple';
    }

    /** @test */
    public function it_should_have_columns_property_defined()
    {
        $tempColumns = ['id', 'name', 'age'];

        $this->repository->columns = $tempColumns;
        $this->assertIsArray($this->repository->columns);
        $this->assertEquals($this->repository->columns, $tempColumns);
    }

    /** @test */
    public function it_should_not_be_able_set_an_wrong_value_to_columns_property()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(trans('common.object.type.array', ['property' => 'columns']));
        $this->repository->columns = 'abc';
    }

    /** @test */
    public function it_should_able_to_get_the_offset_value()
    {
        $this->repository->page = 2;
        $this->repository->limit = 5;
        $this->assertIsInt($this->repository->offset);
        $this->assertEquals($this->repository->offset, 10);
    }

    /** @test */
    public function it_should_not_be_able_set_an_value_to_offset_property()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(trans('common.object.visibility.internal.set', ['property' => 'offset']));
        $this->repository->offset = 10;
    }
}
