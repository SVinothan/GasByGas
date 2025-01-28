<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
Use App\Models\Employee;

class EmployeeFeatureTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_database_entry_Employees_can_be_created()
    {
        $employee = Employee::factory()->create();
        $this->assertDatabaseHas('employees', ['full_name' => $employee->full_name]);
    }
}
