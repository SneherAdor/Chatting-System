<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
        	[
        		'id'   => 1,
        		'name' => 'admin'
        	],
        	[
        		'id'   => 2,
        		'name' => 'editor'
        	],
        	[
        		'id'   => 3,
        		'name' => 'subscriber'
        	],
        ];
        foreach ($roles as $role) {
		        Role::create($role);
		    }
    }
}
