<?php

namespace Tests\Feature\Users;

use Tests\Feature\Helpers\AuthTestBase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticationTest extends AuthTestBase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setRouteGroup('auth');
    }

    /** @test */
    public function it_should_get_an_error_on_set_wrong_credentials(): void
    {
        $credentials = $this->getAuthUserCredentials('secret');
        $response = $this->postJson('/login', $credentials);

        $response->assertUnauthorized();
        $response->assertJsonStructure(['error']);
    }

    /** @test */
    public function it_should_get_a_token_when_pass_correct_credentials(): void
    {
        $this->setAuthUserOnDatabase();

        $response = $this->postJson('/login', $this->credentials);

        $response->assertSuccessful();
        $response->assertJsonStructure(['access_token']);
    }

    /** @test */
    public function it_should_unauthorized_to_access_user_info(): void
    {
        $response = $this->getJson('/me');

        $response->assertUnauthorized();
    }

    /** @test */
    public function it_should_allowed_to_see_user_info(): void
    {
        $this->setAuthUserOnDatabase();

        $user = $this->getAuthUser();

        $response = $this->actingAs($user)
            ->getJson('/me');

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'uuid',
            'email',
            'name',
            'avatar',
            'role_id',
            'api_token'
        ]);
        $this->assertNotEquals(null, $response['api_token']);
    }

    /** @test */
    public function it_should_get_a_new_token_when_refresh_access(): void
    {
        $this->setAuthUserOnDatabase();

        $user = $this->getAuthUser();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/refresh');

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'access_token'
        ]);
        $this->assertNotEquals($token, $response['access_token']);
    }

    /** @test */
    public function it_should_be_successful_on_logout(): void
    {
        $this->setAuthUserOnDatabase();

        $user = $this->getAuthUser();

        $response = $this->actingAs($user)
            ->getJson('/logout');

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'logout'
        ]);
        $this->assertTrue($response['logout']);
    }
}
