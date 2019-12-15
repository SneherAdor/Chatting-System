<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Common;
use App\Models\GeneralSettings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;

class GeneralSettingController extends Controller
{
    protected $helper;

    public function __construct()
    {
        $this->helper = new Common();
    }
    public function edit()
    {	       //Check Auth and Permission
    	if (Auth::check() && Auth::user()->hasPermissionTo('view_settings'))
        {
            $generalSettings = GeneralSettings::all();
            return view('admin.settings.edit')->with('generalSettings', $generalSettings);
        }
        else
        {
            $this->helper->getPermissionErrorMessage();
            return redirect()->back();
        }
    }


    public function update(Request $request, $id)
    {       //Check Auth and Permission
        if (Auth::check() && Auth::user()->hasPermissionTo('edit_settings'))
        {
            
            $this->validate($request, [
                'name'    => 'max:20',
                'email'   => 'email|nullable',
                'language'=> 'required',
                'theme'   => 'required',
                'logo'    => 'mimes:jpg,jpeg,png,bmp,gif',
            ]);

            $generalSettings           = GeneralSettings::findOrFail($id);
            $generalSettings->name     = $request->name;
            $generalSettings->email    = $request->email;
            $generalSettings->language = $request->language;
            $generalSettings->theme    = $request->theme;
            
            $image = $request->file('logo');
            $slug  = str_slug($request->name);

            if (isset($image)) {
                //make unique name for image
                $currentDate = Carbon::now()->toDateString();
                $imageName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
                //check logo directory
                if(!Storage::disk('public')->exists('logo')){
                    Storage::disk('public')->makeDirectory('logo');
                }
                //Delete old Logo
                if(Storage::disk('public')->exists('logo/'.$generalSettings->logo)){
                    Storage::disk('public')->delete('logo/'.$generalSettings->logo);
                 }
                $image->storeAs('public/logo/', $imageName);

            } else {
                $imageName = $generalSettings->logo;
            }

            $generalSettings->logo = $imageName;
            $generalSettings->save();

            activity()->causedBy(auth()->user())->log(__('controllers.update_general_settings'));

            $this->helper->one_time_message('success', __('controllers.update_general_settings'));
            return redirect('settings/general');
            }
        else
        {
            $this->helper->getPermissionErrorMessage();
            return redirect()->back();
        }
    }
}
