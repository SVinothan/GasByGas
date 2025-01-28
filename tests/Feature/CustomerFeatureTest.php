<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
Use App\Models\Customer;

class CustomerFeatureTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_database_entry_customers_can_be_created()
    {
        $customer = Customer::factory()->create();
        $this->assertDatabaseHas('customers', ['full_name' => $customer->full_name]);
    }
}
