<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class HomePageTest extends TestCase
{
    #[Test]
    public function homepage_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}