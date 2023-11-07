<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(20)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            FacilitySeeder::class,
            PropertySeeder::class,
            FacilityPropertySeeder::class,
            RolesAndPermissionSeeder::class,
            CategorySeeder::class,
            UnitSeeder::class,
            ItemSeeder::class,
        ]);
    }
}
