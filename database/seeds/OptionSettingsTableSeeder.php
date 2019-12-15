<?php

use App\Models\OptionSettings;
use Illuminate\Database\Seeder;

class OptionSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $optionSettings = [
        	[
        		'id'   => 1,
        		'name' => 'login-url',
        		'option' => '/',
        	],
            [
                'id'   => 2,
                'name' => 'registration',
                'option' => 'enable',
            ],
            [
                'id'   => 3,
                'name' => 'default-status',
                'option' => 'inactive',
            ],
            [
                'id'   => 4,
                'name' => 'reg_mail_status',
                'option' => 'disable',
            ],
            [
                'id'   => 5,
                'name' => 'reg_mail_to',
                'option' => 'sneherador.sa.sa@gmail.com',
            ],
            [
                'id'   => 6,
                'name' => 'email_verify',
                'option' => 'disable',
            ],
        ];
        foreach ($optionSettings as $optionSetting) {
		        OptionSettings::create($optionSetting);
		}
    }
}
