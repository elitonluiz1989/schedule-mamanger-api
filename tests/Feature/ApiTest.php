<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApiTest extends TestCase
{
    /** @test */
    public function it_should_able_access_api_info()
    {
        $response = $this->getJson('/');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'name',
            'version',
            'timezone',
            'datetime'
        ]);
    }
}
