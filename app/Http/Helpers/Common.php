<?php
namespace App\Http\Helpers;

use App\Models\GeneralSettings;
use Illuminate\Support\Facades\Session;

class Common
{

    public static function one_time_message($class, $message)
    {
        if ($class == 'error')
        {
            $class = 'danger';
        }
        Session::flash('alert-class', 'alert-' . $class);
        Session::flash('message', $message);
    }


    /* Company Name */
    public function getCompanyName()
    {
        $setting = GeneralSettings::select('name')->first();
        return $setting->name;
    }

    /* Company Logo */
    function getCompanyLogo()
    {
        $setting = GeneralSettings::first(['logo']);
        $setting->logo;
    }
    
    /* Permission Error Message */
    function getPermissionErrorMessage()
    {
       Session::flash('alert-class', 'alert-danger');
       Session::flash('message', 'You don\'t have permission to access!');
    }


}