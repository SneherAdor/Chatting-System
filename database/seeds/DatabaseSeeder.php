<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(GeneralSettingsTableSeeder::class);
        $this->call(OptionSettingsTableSeeder::class);

        //Insert data at role_has_permissions table
        $role_has_permissions = [
    		['permission_id' => 1, 'role_id' => 1],
    		['permission_id' => 2, 'role_id' => 1],
    		['permission_id' => 3, 'role_id' => 1],
    		['permission_id' => 4, 'role_id' => 1],
    		['permission_id' => 5, 'role_id' => 1],
    		['permission_id' => 6, 'role_id' => 1],
    		['permission_id' => 7, 'role_id' => 1],
    		['permission_id' => 8, 'role_id' => 1],
            ['permission_id' => 9, 'role_id' => 1],
            ['permission_id' => 10, 'role_id' => 1],
            ['permission_id' => 11, 'role_id' => 1],
    	];
    	foreach ($role_has_permissions as $role_has_permission) {
    		DB::table('role_has_permissions')->insert($role_has_permission);
    	}

        //Insert data at model_has_roles table
        $model_has_roles = [
            ['role_id' => 1, 'model_type' => 'App\User', 'model_id' => 1]
        ];
        foreach ($model_has_roles as $model_has_role) {
            DB::table('model_has_roles')->insert($model_has_role);
        }
    }
}
