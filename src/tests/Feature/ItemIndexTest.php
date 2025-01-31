<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ItemIndexTest extends TestCase
{
    use RefreshDatabase;
    public function test_item_index()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
