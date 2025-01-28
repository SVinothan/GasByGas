<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
Use App\Models\District;

class DistrictFeatureTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_database_entry_Districts_can_be_created()
    {
        $District = District::factory()->create();
        $this->assertDatabaseHas('districts', ['name_en' => $District->name_en]);
    }
}
