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
        $this->call(OrganizationSeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(ManagerSeeder::class);
        $this->call(EventsSeeder::class);
        $this->call(UsersSeeder::class);

    }
}
