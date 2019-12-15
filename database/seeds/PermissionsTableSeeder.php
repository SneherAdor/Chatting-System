<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [

            // Role
            ['id' => 1, 'name' => 'view_role',   'group' => 'Role'], 
            ['id' => 2, 'name' => 'create_role', 'group' => 'Role'], 
            ['id' => 3, 'name' => 'edit_role',   'group' => 'Role'], 
            ['id' => 4, 'name' => 'delete_role', 'group' => 'Role'],
            
            // User
            ['id' => 5, 'name' => 'view_user',   'group' => 'User'], 
            ['id' => 6, 'name' => 'create_user', 'group' => 'User'], 
            ['id' => 7, 'name' => 'edit_user',   'group' => 'User'], 
            ['id' => 8, 'name' => 'delete_user', 'group' => 'User'],

            // Settings
            ['id' => 9, 'name' => 'view_settings',   'group' => 'Settings'], 
            ['id' => 10, 'name' => 'edit_settings', 'group' => 'Settings'], 
            
            //Activity
            ['id' => 11, 'name' => 'view_activities',   'group' => 'Activity'],
        ];
        foreach ($permissions as $permission) {
		        Permission::create($permission);
		    }
    }
}
