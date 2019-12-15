<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [            
		        [
		        	'id' 		=> 1, 
		        	'name'      => 'Mr. Admin',
		        	'status'      => 'active',
			        'email'     => 'admin@qblogin.com',
			        'password'  => bcrypt('12345678'),
		        ],
		        [
		        	'id' 		=> 2, 
		        	'name'      => 'Mr. Editor',
			        'email'     => 'editor@qblogin.com',
		        	'status'      => 'inactive',
			        'password'  => bcrypt('12345678'),
		        ],
		        [
		        	'id' 		=> 3, 
		        	'name'      => 'Mr. Subscriber',
		        	'status'      => 'disabled',
			        'email'     => 'subscriber@qblogin.com',
			        'password'  => bcrypt('12345678'),
		        ],
		    ];
		    foreach ($users as $user) {
		        User::create($user);
		    }
    }
}
