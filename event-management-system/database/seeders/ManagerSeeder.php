<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manager = User::create([
           'last_name' => 'Сальников',
           'first_name' => 'Евгений',
           'patronymic' => 'Андреевич',
           'email' => 'manager@example.com',
           'password' => bcrypt('password')
        ]);

        $managerRole = Role::where('name', 'manager')->first();

        $manager->assignRole($managerRole);
    }
}
