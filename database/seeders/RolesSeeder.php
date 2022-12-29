<?php

namespace Database\Seeders;

use App\Models\ModelHasRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\Hash;


class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

//        // create permissions
        Permission::create(['name' => 'letters crud']);
        Permission::create(['name' => 'user crud']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'editor']);
        $role1->givePermissionTo('letters crud');

        $role2 = Role::create(['name' => 'admin']);
        $role2->givePermissionTo('user crud');

        // create demo users
        $user1 = \App\Models\User::create([
            'uuid' => '1',
            'email' => 'editor@test.com',
            'password' => Hash::make('123456')
        ]);
        $user1->assignRole('editor');

        $user2 = \App\Models\User::create([
            'uuid' => '2',
            'email' => 'admin@test.com',
            'password' => Hash::make('123456')
        ]);

        ModelHasRole::create([
            'role_id' => 2,
            'model_type' => 'App\Models\User',
            'model_id' => 2,
        ]);
    }
}
