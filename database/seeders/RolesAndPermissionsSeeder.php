<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создание ролей
        $managerRole = Role::create(['name' => 'manager', 'guard_name' => 'web', 'comment' => 'Менеджер']);
        $employeeRole = Role::create(['name' => 'employee', 'guard_name' => 'web', 'comment' => 'Сотрудник']);
        $participantRole = Role::create(['name' => 'participant', 'guard_name' => 'web', 'comment' => 'Участник мероприятий']);

        // Проверка, что роли созданы
        if (!$managerRole || !$employeeRole || !$participantRole) {
            throw new \Exception('Failed to create one or more roles');
        }

        // Создание разрешений
        $permissions = [
            'create users',
            'edit users',
            'delete users',
            'view users',
            'roles', // назначение главных ролей (менеджер)
            'create events',
            'edit events',
            'delete events',
            'view events',
            'participant view events', // Исправлено на participant view events
            'scan qr codes',
            'attach participant to events' // Исправлено на attach participant to events
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Назначение разрешений ролям
        $managerRole->givePermissionTo(Permission::all()); // Назначение всех разрешений администратору

        $employeeRole->givePermissionTo([
            'attach participant to events',
            'view events',
            'scan qr codes'
        ]);

        $participantRole->givePermissionTo([
            'participant view events'
        ]);
    }
}
