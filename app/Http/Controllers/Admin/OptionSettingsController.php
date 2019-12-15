<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Common;
use App\Models\OAuth;
use App\Models\OptionSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Auth;
// use App\Http\Helpers\Common;

class OptionSettingsController extends Controller
{
	public function __construct()
    {
        $this->helper = new Common();
    }

    
    public function editloginurl()
    {          //Check Auth and Permission
        if (Auth::check() && Auth::user()->hasPermissionTo('view_settings'))
        {
            $loginUrl = OptionSettings::where('name', 'login-url')->get();
            return view('admin.loginurl.edit')->with('loginUrl', $loginUrl);
        }
        else
        {
            $this->helper->getPermissionErrorMessage();
            return redirect()->back();
        }
    }



    public function updateloginurl(Request $request, $id)
    {       //Check Auth and Permission
        if (Auth::check() && Auth::user()->hasPermissionTo('edit_settings'))
        {
                $this->validate($request, [
                'url'    => 'required',
                ]);

                $LoginUrl           = OptionSettings::findOrFail($id);
                $LoginUrl->option     = $request->url;
                $LoginUrl->save();

                activity()->causedBy(auth()->user())->log(__('controllers.update_login_url'));

                $this->helper->one_time_message('success', __('controllers.update_login_url'));
                return redirect('settings/login-url');
                }
        else
        {
            $this->helper->getPermissionErrorMessage();
            return redirect()->back();
        }

    }

    public function options()
    {          //Check Auth and Permission
        if (Auth::check() && Auth::user()->hasPermissionTo('view_settings'))
        {
            return view('admin.options.edit');
        }
        else
        {
            $this->helper->getPermissionErrorMessage();
            return redirect()->back();
        }
    }

    public function optionsUpdate(Request $request)
    {       //Check Auth and Permission
        if (Auth::check() && Auth::user()->hasPermissionTo('edit_settings'))
        {
            $this->validate($request, [
            'registration'    => 'required',
            'defaultstatus'    => 'required',
            'reg_mail_status'    => 'required',
            'email_verify'    => 'required',
            'reg_mail_to'    => 'required|email',
        ]);

            DB::table('option_settings')->where('name', 'registration')
                ->update(['option' => $request->registration]);
            DB::table('option_settings')->where('name', 'default-status')
                ->update(['option' => $request->defaultstatus]);
            DB::table('option_settings')->where('name', 'reg_mail_status')
                ->update(['option' => $request->reg_mail_status]);
            DB::table('option_settings')->where('name', 'reg_mail_to')
                ->update(['option' => $request->reg_mail_to]);
            DB::table('option_settings')->where('name', 'email_verify')
                ->update(['option' => $request->email_verify]);

            activity()->causedBy(auth()->user())->log(__('controllers.update_option_settings'));

            $this->helper->one_time_message('success', __('controllers.update_option_settings'));
            return redirect('settings/options');
        }
        else
        {
            $this->helper->getPermissionErrorMessage();
            return redirect()->back();
        }

    }


    public function githuboauth()
    {          //Check Auth and Permission
        if (Auth::check() && Auth::user()->hasPermissionTo('view_settings'))
        {
            return view('admin.oauth.github');
        }
        else
        {
            $this->helper->getPermissionErrorMessage();
            return redirect()->back();
        }
    }

    public function facebookoauth()
    {          //Check Auth and Permission
        if (Auth::check() && Auth::user()->hasPermissionTo('view_settings'))
        {
            return view('admin.oauth.facebook');
        }
        else
        {
            $this->helper->getPermissionErrorMessage();
            return redirect()->back();
        }
    }

    public function googleoauth()
    {          //Check Auth and Permission
        if (Auth::check() && Auth::user()->hasPermissionTo('view_settings'))
        {
            return view('admin.oauth.google');
        }
        else
        {
            $this->helper->getPermissionErrorMessage();
            return redirect()->back();
        }
    }

    public function updateoauth(Request $request, $id)
    {       //Check Auth and Permission
        if (Auth::check() && Auth::user()->hasPermissionTo('edit_settings'))
        {
            if($request->status == true){
            $this->validate($request, [
                'client_id'    => 'required',
                'client_secret'    => 'required',
                'redirect'    => 'required',
                'status'    => 'required',
            ]);
        }else{
            $this->validate($request, [
                'status'    => 'required',
            ]);
        }
            $path = base_path('.env');
            $env = file_get_contents($path);

            if(env($this->getProvider($id).'_CLIENT_ID')){
                $env = str_replace($this->getProvider($id).'_CLIENT_ID='.env($this->getProvider($id).'_CLIENT_ID'), $this->getProvider($id).'_CLIENT_ID='.$request->client_id, $env);

                $env = str_replace($this->getProvider($id).'_CLIENT_SECRET='.env($this->getProvider($id).'_CLIENT_SECRET'), $this->getProvider($id).'_CLIENT_SECRET='.$request->client_secret, $env);

                $env = str_replace($this->getProvider($id).'_CALLBACK='.env($this->getProvider($id).'_CALLBACK'), $this->getProvider($id).'_CALLBACK='.$request->redirect, $env);

                $env = str_replace($this->getProvider($id).'_STATUS='.env($this->getProvider($id).'_STATUS'), $this->getProvider($id).'_STATUS='.$request->status, $env);

                file_put_contents($path, $env);
            }
            else
            {
                $env = "\n".$this->getProvider($id).'_CLIENT_ID='.$request->client_id;
                file_put_contents($path, $env, FILE_APPEND);

                $env = "\n".$this->getProvider($id).'_CLIENT_SECRET='.$request->client_secret;
                file_put_contents($path, $env, FILE_APPEND);

                $env = "\n".$this->getProvider($id).'_CALLBACK='.$request->redirect;
                file_put_contents($path, $env, FILE_APPEND);

                $env = "\n".$this->getProvider($id).'_STATUS='.$request->status;
                file_put_contents($path, $env, FILE_APPEND);
            }

        activity()->causedBy(auth()->user())->log(__('controllers.update_oauth'));

        $this->helper->one_time_message('success', __('controllers.update_oauth'));
        return redirect()->back();
        }
        else
        {
            $this->helper->getPermissionErrorMessage();
            return redirect()->back();
        }

    }

    public function getProvider($id)
    {
        if ($id == 1) {
            return 'GITHUB';
        }
        elseif ($id == 2) {
            return 'FACEBOOK';
        }
        elseif ($id == 3) {
            return 'GOOGLE';
        }
        else{
            abort(404);
        }
    }
    
}
