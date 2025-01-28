<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
Use App\Models\Item;

class ItemFeatureTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_database_entry_Items_can_be_created()
    {
        $item = Item::factory()->create();
        $this->assertDatabaseHas('items', ['name' => $item->name]);
    }
}
