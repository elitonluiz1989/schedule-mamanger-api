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
	 * Repository properties
	 */
	private array $properties = [
	    'page' => 1,
        'limit' => 12,
        'columns' => []
    ];

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
		if (in_array($property, $this->propertiesDenied['set'])) {
			throw new Exception(trans('common.object.visibility.internal.set', ['property' => $property]));
		}

		if ($property == 'page') {
			if (!is_int($value)) {
				throw new Exception(trans('common.object.type.int', ['property' => $property]));
			}

			if ($value <= 0) {
				$value = 1;
			}
		}

		if ($property == 'limit' && !is_int($value)) {
			throw new Exception(trans('common.object.type.int', ['property' => $property]));
		}

		if (($property == 'columns') &&  (!is_array($value))) {
			throw new Exception(trans('common.object.type.array', ['property' => $property]));
		}

		$this->properties[$property] = $value;
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
			return $this->properties['page'] * $this->properties['limit'];
		}

		return $this->properties[$property];
	}
}
