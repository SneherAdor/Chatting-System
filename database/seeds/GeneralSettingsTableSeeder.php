<?php

use App\Models\GeneralSettings;
use Illuminate\Database\Seeder;

class GeneralSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $generalSettings = [
        	[
        		'id'   => 1,
        		'name' => 'QbLogin',
        		'email' =>'site@qblogin.com',
        		'language' => 'en',
        		'theme' => 'skin-green',
        	]
        ];
        foreach ($generalSettings as $generalSetting) {
		        GeneralSettings::create($generalSetting);
		}
    }
}
