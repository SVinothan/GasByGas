<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
Use App\Models\Outlet;

class OutletFeatureTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_database_entry_Outlets_can_be_created()
    {
        $outlet = Outlet::factory()->create();
        $this->assertDatabaseHas('outlets', ['outlet_name' => $outlet->outlet_name]);
    }
}
