<?php

namespace App\Repositories;

use App\Contracts\Repositories\RepositoryContract;
use App\Helpers\Repositories\RepositoryHelper;
use Illuminate\Database\Eloquent\Model;
use\Illuminate\Contracts\Pagination\LengthAwarePaginator;
use ReflectionClass;
use ReflectionException;

class BaseRepository implements RepositoryContract
{
    use RepositoryHelper;

	/**
	 * The model used to manipulate data
	 */
	protected Model $model;

	/**
	 * BaseRepository class constructor
	 *
	 * @param Model $model	 *
	 * @return void
	 */
	public function __construct(Model $model)
	{
		$this->propertiesDenied['set'] = ['model', 'offset'];
		$this->model = $model;
	}

	/**
	 *
	 * Data manipulation methods
	 *
	 */

	/**
	 * Retrieve all records
	 *
     * @param array $filters
	 * @return LengthAwarePaginator
	 */
	public function all(array $filters = []): LengthAwarePaginator
	{
		return $this->find($filters);
	}

	/**
	 * Retrieve all or one that match with the filter
	 *
	 * @param array $filters
	 * @return LengthAwarePaginator
     */
	public function find(array $filters = []): LengthAwarePaginator
    {
		$query = $this->model->query();

		if (count($filters) > 0) {
			$query->where($filters);
		}

		if (count($this->columns) > 0) {
			$query->select($this->columns);
		}

		return $query->paginate($this->offset);
	}

	/**
	 * Saves passed data
	 *
	 * @param array 	$data
	 * @param string	$key
	 * @return Model
	 */
	public function store(array $data, string $key = 'id'): Model
	{
		$model = $this->getNewModel();

		if (array_key_exists($key, $data)) {
			$model = $this->model->where($key, $data[$key])->first();

			unset($data[$key]);
		}

		foreach ($data as $column => $value) {
			$model->$column = $value;
		}

		$model->save();

		return $model;
	}

	/**
	 * Remove ones that match with the filter
	 *
	 * @param mixed $filters
	 * @return boolean
	 */
	public function remove($filters): bool
	{
		$model = $this->model->where($filters)->first();
		$model->delete();

		return true;
	}

	/**
	 * Class's tools
	 */

    /**
     * Returns the model instance of child repository class
     *
     * @return object
     * @throws ReflectionException
     */
	private function getNewModel(): object
	{
		$className = get_class($this->model);
		$reflection = new ReflectionClass($className);

		return $reflection->newInstance();
	}
}
