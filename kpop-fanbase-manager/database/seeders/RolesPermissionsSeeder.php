<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesPermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            ['name' => 'Manage Users', 'slug' => 'manage-users'],
            ['name' => 'Manage Groups', 'slug' => 'manage-groups'],
            ['name' => 'Manage Songs', 'slug' => 'manage-songs'],
            ['name' => 'Manage Events', 'slug' => 'manage-events'],
            ['name' => 'Access Admin', 'slug' => 'access-admin'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        $roles = [
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'permissions' => Permission::all()->pluck('id')->toArray()
            ],
            [
                'name' => 'Manager',
                'slug' => 'manager',
                'permissions' => Permission::whereIn('slug', [
                    'manage-groups', 
                    'manage-songs',
                    'manage-events'
                ])->pluck('id')->toArray()
            ],
            [
                'name' => 'Fan',
                'slug' => 'fan',
                'permissions' => []
            ]
        ];

        foreach ($roles as $roleData) {
            $role = Role::create([
                'name' => $roleData['name'],
                'slug' => $roleData['slug']
            ]);
            
            $role->permissions()->sync($roleData['permissions']);
        }
    }
}