<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Получение всех мероприятий
        $events = Event::all();
        $organizations = Organization::all();

        // Создание администраторов
        $managerRole = Role::where('name', 'manager')->first();
        $managers = User::factory()->count(3)->create();
        foreach ($managers as $manager) {
            $manager->assignRole($managerRole);
        }

        // Создание работников
        $employeeRole = Role::where('name', 'employee')->first();
        $employees = User::factory()->count(12)->create();
        foreach ($employees as $employee) {
            $employee->assignRole($employeeRole);
        }

        // Создание пользователей и прикрепление их к одному или нескольким мероприятиям
        $participant = Role::where('name', 'participant')->first();
        User::factory()->count(180)->create()->each(function ($user) use ($events, $participant, $organizations) {
            $user->events()->attach(
                $events->random(rand(1, 3))->pluck('id')->toArray()
            );

            // привязка к случайной организации
            $user->organization_id = $organizations->random()->id;
            $user->save();

            // присвоение роли participant
            $user->assignRole($participant);
        });
    }
}
