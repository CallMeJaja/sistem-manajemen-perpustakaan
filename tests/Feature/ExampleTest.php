<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_redirects_home_to_catalog(): void
    {
        $response = $this->get('/');
        $response->assertRedirect(route('catalog.index'));
    }

    public function test_the_catalog_returns_a_successful_response(): void
    {
        $response = $this->get('/catalog');
        $response->assertStatus(200);
    }
}
