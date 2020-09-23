<?php

namespace Tests;

use App\Console\Kernel;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabaseState;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Helpers\InstancesHelper;
use Tests\Helpers\JsonRequestHelper;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication,
        DatabaseMigrations,
        RefreshDatabase,
        InstancesHelper,
        JsonRequestHelper;

    /**
     * Set the default uri use on tests
     */
    private string $uri;

    public function setUp(): void
    {
        parent::setUp();

        $this->uri = env('APP_TESTING_URL', '/api/v1');
    }

    /**
     * Define hooks to migrate the database before and after each test.
     *
     * @return void
     */
    public function runDatabaseMigrations()
    {
        $this->artisan('migrate:fresh --path=database/migrations');
        $this->artisan('migrate --path=tests/database/migrations');

        $this->app[Kernel::class]->setArtisan(null);

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('migrate:rollback');

            RefreshDatabaseState::$migrated = false;
        });
    }

    /**
     * Set the currently logged in user for the application.
     *
     * @param Authenticatable $user
     * @param null $driver
     * @return TestCase
     */
    public function actingAs($user, $driver = null)
    {
        $token = JWTAuth::fromUser($user);
        $this->withHeader('Authorization', "Bearer {$token}");
        $user->api_token = $token;
        $user->save();

        parent::actingAs($user);

        return $this;
    }
}
