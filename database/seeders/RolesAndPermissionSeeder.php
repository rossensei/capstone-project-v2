<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin']);
        $faculty = Role::create(['name' => 'faculty']);

        Permission::create(['name' => 'create-user']);
        Permission::create(['name' => 'request-item']);
        Permission::create(['name' => 'view']);
        Permission::create(['name' => 'edit']);
        Permission::create(['name' => 'delete']);
        Permission::create(['name' => 'add']);

        $admin->givePermissionTo(Permission::all());
        $faculty->givePermissionTo(['request-item', 'view']);
        
        $users = User::all();

        foreach($users as $user) {
            $user->assignRole('faculty');
        }

        $adminUser = User::create([
            'user' => 'rossensei',
            'name' => 'Rosalino Flores',
            'email' => 'fross0988@gmail.com',
            'password' => 'admin123',
        ]);

        $adminUser->assignRole('admin');
    }
}
