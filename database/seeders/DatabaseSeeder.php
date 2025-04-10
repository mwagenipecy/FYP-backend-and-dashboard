<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Level;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

           // Create roles
        //    $roles = [
        //     ['name' => 'Admin', 'description' => 'System Administrator'],
        //     ['name' => 'Manager', 'description' => 'Department Manager'],
        //     ['name' => 'Staff', 'description' => 'Regular Staff Member'],
        //     ['name' => 'Intern', 'description' => 'Intern Staff']
        // ];

        // foreach ($roles as $role) {
        //     Role::create($role);
        // }

        // // Create levels
        // $levels = [
        //     ['name' => 'First Year', 'description' => 'Entry Level'],
        //     ['name' => 'Second Year', 'description' => 'Mid Level'],
        //     ['name' => 'Third Year', 'description' => 'Senior Level'],
        //     ['name' => 'Fourth Year', 'description' => 'Lead Level']
        // ];

        // foreach ($levels as $level) {
        //     Level::create($level);
        // }

        // // Create admin user
        // User::create([
        //     'name' => 'Admin User',
        //     'email' => 'admin@example.com',
        //     'regno' => 'ADM001',
        //     'password' => Hash::make('password'),
        //     'role_id' => 1, // Admin role
        //     'level_id' => 4, // Lead level
        // ]);

        // // Create sample users
        // User::factory(20)->create();



        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        $this->call(ProjectManagementSeeder::class);

    }
}
