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
}
