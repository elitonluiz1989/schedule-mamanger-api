<?php

namespace App\Contracts\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

interface RepositoryContract
{
	/**
	 * Properties setter
	 *
	 * @param string $property
	 * @param mixed $value
	 *
	 * @return void
	 */
	public function __set(string $property, $value): void;

	/**
	 * Properties getter
	 *
	 * @param string $property
	 * @return mixed
	 */
	public function __get(string $property);

	/**
	 * Retrieve all records
	 *
     * @param  array $filters
	 * @return LengthAwarePaginator
	 */
	public function all(array $filters = []): LengthAwarePaginator;

	/**
	 * Retrieve all or ones that match with the filter
	 *
	 * @param array $filters
	 * @return LengthAwarePaginator
	 */
	public function find(array $filters = []): LengthAwarePaginator;

	/**
	 * Save the past data
	 *
	 * @param array		$data
	 * @param string	$key
	 * @return Model
	 */
	public function store(array $data, string $key = 'id'): Model;

	/**
	 * Removes ones that match with the filter
	 *
	 * @param mixed $filters	 *
	 * @return boolean
	 */
	public function remove($filters): bool;
}
