<?php

namespace Tests\Feature\Helpers;

use App\Models\Users\User;
use Illuminate\Contracts\Auth\Authenticatable;
use WebmasterSeeder;

trait AuthTestHelper
{
    protected array $credentials;

    /**
     * Set an authenticable user on database
     *
     * @return void
     */
    protected function setAuthUserOnDatabase(): void
    {
        $this->seed(WebmasterSeeder::class);

        $this->assertDatabaseHas('users', ['email' => $this->getAuthUserCredentials()['email']]);
    }

    /**
     * Retrieve an authenticated user
     *
     * @return Authenticatable
     */
    protected function getAuthUser(): Authenticatable
    {
        $this->setAuthUserOnDatabase();

        $credentials = $this->getAuthUserCredentials();

        return User::where('email', $credentials['email'])->first();
    }

    /**
     * Retrieve the high level user auth credentials
     *
     * @param mixed $secret
     * @return array
     */
    protected function getAuthUserCredentials($secret = null): array
    {
        return [
            'email' => env('WEBMASTER_EMAIL'),
            'password' => $secret ?? env('WEBMASTER_PASSWORD')
        ];
    }
}
