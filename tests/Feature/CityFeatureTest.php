<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
Use App\Models\City;

class CityFeatureTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_database_entry_city_can_be_created()
    {
        $city = City::factory()->create();
        $this->assertDatabaseHas('cities', ['name_en' => $city->name_en]);
    }
}
