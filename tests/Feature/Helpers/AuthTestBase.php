<?php


namespace Tests\Feature\Helpers;

use Tests\TestCase;

abstract class AuthTestBase extends TestCase
{
    use AuthTestHelper;

    public function setUp(): void
    {
        parent::setUp();

        $this->credentials = $this->getAuthUserCredentials();
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
}
