<?php

namespace Tests\Helpers;

use Illuminate\Testing\TestResponse;

trait JsonRequestHelper
{
    private string $currentUri;

	/**
	 * On set the get method uri add the default uri
	 *
	 * @param string    $uri
	 * @param array     $headers
     * @return TestResponse
     */
	public function getJson($uri, array $headers = []): TestResponse
	{
		$this->currentUri = $this->setNewUri($uri);

		return parent::getJson($this->currentUri, $headers);
	}

	/**
	 * On set the post method uri add the default uri
	 *
	 * @param string $uri
	 * @param array $data
	 * @param array $headers
	 * @return TestResponse
	 */
	public function postJson($uri, array $data = [], array $headers = []): TestResponse
	{
        $this->currentUri = $this->setNewUri($uri);

		return parent::postJson($this->currentUri, $data, $headers);
	}

	/**
	 * On set the put method uri add the defult uri
	 *
	 * @param string $uri
	 * @param array $data
	 * @param array $headers
	 * @return TestResponse
	 */
	public function putJson($uri, array $data = [], array $headers = []): TestResponse
	{
		$this->setNewUri($uri);

		return parent::putJson($uri, $data, $headers);
	}

	/**
	 * On set the delete method uri add the defult uri
	 *
	 * @param string $uri
	 * @param array $data
	 * @param array $headers
	 * @return TestResponse
	 */
	public function deleteJson($uri, array $data = [], array $headers = []): TestResponse
	{
        $this->currentUri = $this->setNewUri($uri);

		return parent::deleteJson($this->currentUri, $data, $headers);
	}

	/**
	 * Get the default uri
	 *
	 * @return string
	 */
	public function getUri(): string
	{
		return $this->currentUri ?? $this->uri;
	}

	/**
	 * Redefine the default uri with a route group
	 *
	 * @param string $group
	 * @return void
	 */
	protected function setRouteGroup(string $group): void
	{
		$this->uri = env('APP_TESTING_URL', '/api/v1') . '/' . $group;
	}

	/**
	 * Added to passed uri the default uri value
	 *
	 * @param string $uri
	 * @return string
	 */
	private function setNewUri(string $uri): string
	{
		return $this->uri . $uri;
	}
}
