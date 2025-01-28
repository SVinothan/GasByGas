<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
Use App\Models\Province;

class ProvinceFeatureTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_database_entry_Provinces_can_be_created()
    {
        $province = Province::factory()->create();
        $this->assertDatabaseHas('provinces', ['name_en' => $province->name_en]);
    }
}
