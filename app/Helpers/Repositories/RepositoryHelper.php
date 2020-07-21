<?php

namespace App\Helpers\Repositories;

use Exception;

trait RepositoryHelper
{
	/**
	 * List of the denied properties.
	 * Prevents the external manipulation on __set or __get method
	 */
	protected array $propertiesDenied = [
		'set' => [],
		'get' => []
	];

	/**
	 * Current page on pagination
	 */
	private int $page = 1;

	/**
	 * Limit data per page value
	 */
	private int $limit = 12;

	/**
	 * Desired columns to be retrieved on search
	 */
	private array $columns = [];

	/**
	 * Properties setter
	 *
	 * @param string $property
	 * @param mixed $value
	 * @return void
     * @throws Exception
	 */
	public function __set(string $property, $value): void
	{
		if (\in_array($property, $this->propertiesDenied['set'])) {
			throw new Exception(trans('common.validation.visibility.internal.set', ['property' => $property]));
		}

		if ($property == 'page') {
			if (!\is_int($value)) {
				throw new Exception(trans('common.validation.type.int', ['property' => $property]));
			}

			if ($value <= 0) {
				$value = 1;
			}
		}

		if ($property == 'limit' && !\is_int($value)) {
			throw new Exception(trans('common.validation.type.int', ['property' => $property]));
		}

		if (($property == 'columns') &&  (!\is_array($value))) {
			throw new Exception(trans('common.validation.type.array', ['property' => $property]));
		}

		$this->$property = $value;
	}

	/**
	 * Properties getter
	 *
	 * @param string $property
	 * @return mixed
	 */
	public function __get(string $property)
	{
		if ($property == 'offset') {
			return $this->page * $this->limit;
		}

		return $this->$property;
	}
}