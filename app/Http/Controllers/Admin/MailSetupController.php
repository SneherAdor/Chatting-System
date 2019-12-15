<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Common;
use App\Models\MailSetup;
use Illuminate\Http\Request;
use Auth;

class MailSetupController extends Controller
{
	public function __construct()
    {
        $this->helper = new Common();
    }

    public function mail()
    {       //Check Auth and Permission
        if (Auth::check() && Auth::user()->hasPermissionTo('view_settings'))
        {
            return view('admin.mail.mail');
        }
        else
        {
            $this->helper->getPermissionErrorMessage();
            return redirect()->back();
        }
    }

    
    public function updateMail(Request $request, $id)
    {       //Check Auth and Permission
        if (Auth::check() && Auth::user()->hasPermissionTo('edit_settings'))
        {
            
            if($request->status == 'enable'){
                $this->validate($request, [
                    'mail_driver'    => 'required',
                    'mail_host'    => 'required',
                    'mail_port'    => 'required',
                    'mail_username'    => 'required',
                    'mail_password'    => 'required',
                    'mail_encryption'    => 'required',
                    'mail_from'    => 'required',
                    'status'    => 'required',
                ]);
            }else{
                $this->validate($request, [
                    'status'    => 'required',
                ]);
            }

            $path = base_path('.env');
            $env = file_get_contents($path);
            // If already exit on .env file
            if(env('MAIL_DRIVER')){
                $env = str_replace('MAIL_DRIVER='.env('MAIL_DRIVER'), 'MAIL_DRIVER='.$request->mail_driver, $env);

                $env = str_replace('MAIL_HOST='.env('MAIL_HOST'), 'MAIL_HOST='.$request->mail_host, $env);
                
                $env = str_replace('MAIL_PORT='.env('MAIL_PORT'), 'MAIL_PORT='.$request->mail_port, $env);
                
                $env = str_replace('MAIL_USERNAME='.env('MAIL_USERNAME'), 'MAIL_USERNAME='.$request->mail_username, $env);
                
                $env = str_replace('MAIL_PASSWORD='.env('MAIL_PASSWORD'), 'MAIL_PASSWORD='.$request->mail_password, $env);
                
                $env = str_replace('MAIL_ENCRYPTION='.env('MAIL_ENCRYPTION'), 'MAIL_ENCRYPTION='.$request->mail_encryption, $env);
                
                $env = str_replace('MAIL_FROM_NAME='.env('MAIL_FROM_NAME'), 'MAIL_FROM_NAME='.$request->mail_from, $env);
                
                $env = str_replace('MAIL_STATUS='.env('MAIL_STATUS'), 'MAIL_STATUS='.$request->status, $env);

                file_put_contents($path, $env);
            }
            else // If not exit on .env file
            {
                $env = "\n".'MAIL_DRIVER='.$request->mail_driver;
                file_put_contents($path, $env, FILE_APPEND);

                $env = "\n".'MAIL_HOST='.$request->mail_host;
                file_put_contents($path, $env, FILE_APPEND);

                $env = "\n".'MAIL_PORT='.$request->mail_port;
                file_put_contents($path, $env, FILE_APPEND);

                $env = "\n".'MAIL_USERNAME='.$request->mail_username;
                file_put_contents($path, $env, FILE_APPEND);

                $env = "\n".'MAIL_PASSWORD='.$request->mail_password;
                file_put_contents($path, $env, FILE_APPEND);

                $env = "\n".'MAIL_ENCRYPTION='.$request->mail_encryption;
                file_put_contents($path, $env, FILE_APPEND);

                $env = "\n".'MAIL_FROM_NAME='.$request->mail_from;
                file_put_contents($path, $env, FILE_APPEND);

                $env = "\n".'MAIL_STATUS='.$request->status;
                file_put_contents($path, $env, FILE_APPEND);
            }

            activity()->causedBy(auth()->user())->log(__('controllers.update_mail'));

            $this->helper->one_time_message('success', __('controllers.update_mail'));
            return redirect()->back();

        }
        else
        {
            $this->helper->getPermissionErrorMessage();
            return redirect()->back();
        }
    }
}
