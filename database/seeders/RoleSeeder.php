<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permission = new Permission();
        $permission->name = 'action-all';
        $permission->save();

        $role = new Role();
        $role->name = 'admin';
        $role->save();
        $role->permissions()->attach($permission);
        $permission->roles()->attach($role);

        $permission = new Permission();
        $permission->name = 'action-post-delete';
        $permission->save();

        $role = new Role();
        $role->name = 'moderator';
        $role->save();
        $role->permissions()->attach($permission);
        $permission->roles()->attach($role);

        $permission = new Permission();
        $permission->name = 'action-post';
        $permission->save();

        $role = new Role();
        $role->name = 'user';
        $role->save();
        $role->permissions()->attach($permission);
        $permission->roles()->attach($role);

        $admin = Role::where('name', 'admin')->first();
        $moderatorRole = Role::where('name', 'moderator')->first();
        $userRole = Role::where('name', 'user')->first();

        $action_all = Permission::where('name', 'action-all')->first();
        $action_post_delete = Permission::where('name', 'action-post-delete')->first();
        $action_post = Permission::where('name', 'action-post')->first();

        $admin = new User();
        $admin->name = 'Admin';
        $admin->email = 'admin@gmail.com';
        $admin->password = bcrypt('admin');
        $admin->save();
        $admin->roles()->attach($admin);
        $admin->permissions()->attach($action_all);

        $user = new User();
        $user->name = 'Moderator';
        $user->email = 'moderator@gmail.com';
        $user->password = bcrypt('moderator');
        $user->save();
        $user->roles()->attach($moderatorRole);
        $user->permissions()->attach($action_post_delete);

        $user = new User();
        $user->name = 'User';
        $user->email = 'user@gmail.com';
        $user->password = bcrypt('user');
        $user->save();
        $user->roles()->attach($userRole);
        $user->permissions()->attach($action_post);
    }
}
