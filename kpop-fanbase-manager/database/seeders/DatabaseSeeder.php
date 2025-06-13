<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Song;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create permissions
        $permissions = [
            'manage-users' => 'Manage users and their roles',
            'manage-groups' => 'Manage K-POP groups',
            'manage-events' => 'Create and manage events',
            'manage-songs' => 'Manage songs and ratings',
        ];

        foreach ($permissions as $slug => $description) {
            Permission::create([
                'name' => ucfirst(str_replace('-', ' ', $slug)),
                'slug' => $slug,
                'description' => $description,
            ]);
        }

        // Create roles
        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'System administrator with full access',
        ]);

        $managerRole = Role::create([
            'name' => 'Manager',
            'slug' => 'manager',
            'description' => 'Can manage events and content',
        ]);

        $fanRole = Role::create([
            'name' => 'Fan',
            'slug' => 'fan',
            'description' => 'Regular fan with basic access',
        ]);

        // Assign permissions to roles
        $adminRole->permissions()->attach(Permission::all());
        $managerRole->permissions()->attach(Permission::whereIn('slug', ['manage-events', 'manage-songs'])->get());

        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@kpopfanbase.com',
            'password' => Hash::make('password'),
            'birth_date' => '1990-01-01',
            'type' => 'admin',
        ]);

        $admin->roles()->attach($adminRole);

        // Create manager user
        $manager = User::create([
            'name' => 'Event Manager',
            'email' => 'manager@kpopfanbase.com',
            'password' => Hash::make('password'),
            'birth_date' => '1995-01-01',
            'type' => 'manager',
        ]);

        $manager->roles()->attach($managerRole);

        // Create regular users
        User::factory(20)->create(['type' => 'fan'])
            ->each(function ($user) use ($fanRole) {
                $user->roles()->attach($fanRole);
            });

        // Create groups
        $groups = [
            ['name' => 'BTS', 'company' => 'HYBE', 'debut_date' => '2013-06-13'],
            ['name' => 'BLACKPINK', 'company' => 'YG Entertainment', 'debut_date' => '2016-08-08'],
            ['name' => 'TWICE', 'company' => 'JYP Entertainment', 'debut_date' => '2015-10-20'],
            ['name' => 'EXO', 'company' => 'SM Entertainment', 'debut_date' => '2012-04-08'],
            ['name' => 'Red Velvet', 'company' => 'SM Entertainment', 'debut_date' => '2014-08-01'],
        ];

        foreach ($groups as $group) {
            Group::create($group + [
                'description' => 'Popular K-POP group ' . $group['name'],
                'photo' => 'group-photos/' . strtolower($group['name']) . '.jpg',
            ]);
        }

        // Create songs for groups
        Group::all()->each(function ($group) {
            Song::factory(5)->create(['group_id' => $group->id]);
        });

        // Create events
        Event::factory(10)->create(['user_id' => $manager->id]);
    }
}
