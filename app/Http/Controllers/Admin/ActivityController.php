<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use App\Http\Helpers\Common;
use Auth;

class ActivityController extends Controller
{
	protected $helper;

    public function __construct()
    {
        $this->helper = new Common();
    }

    
    public function index()
    {       //Check Auth and Permission
    	if (Auth::check() && Auth::user()->hasPermissionTo('view_activities')) 
    	{
    		$lastActivities = Activity::orderBy('created_at','desc')->get();
    		return view('admin.activities.index')->with('lastActivities', $lastActivities);
    	}
    	else
    	{
    	    $this->helper->getPermissionErrorMessage();
    	    return redirect()->back();
    	}
    }
}
