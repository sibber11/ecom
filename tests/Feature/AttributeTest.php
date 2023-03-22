<?php

namespace Tests\Feature;

use App\Models\Attribute;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AttributeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_attribute_can_be_seeded()
    {
        $this->seed(\Database\Seeders\AttributeSeeder::class);
        $this->assertDatabaseCount('attributes', 4);
        $this->assertDatabaseCount('options', 65);
    }
}
