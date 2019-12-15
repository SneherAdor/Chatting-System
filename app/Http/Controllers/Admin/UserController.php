<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Common;
use App\Mail\RegisterMail;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
    protected $helper;

    public function __construct()
    {
        $this->helper = new Common();
    }

    public function index()
    {        //Check Auth and Permission
    	if (Auth::check() && Auth::user()->hasPermissionTo('view_user'))
        {
          $users = User::orderBy('created_at', 'desc')->paginate(10);
          return view('admin.users.index')->with('users', $users);      
        }
        else
        {
            $this->helper->getPermissionErrorMessage();
            return redirect()->back();
        }
        
          
    }

    public function create()
    {       //Check Auth and Permission
        if (Auth::check() && Auth::user()->hasPermissionTo('create_user'))
        {
            $roles = Role::all();
            return view('admin.users.create')->with('roles', $roles);
        }
        else
        {
            $this->helper->getPermissionErrorMessage();
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {            //Check Auth and Permission
        if (Auth::check() && Auth::user()->hasPermissionTo('create_user'))
        {
            $this->validate($request, [
            'name'                  => 'required|max:255',
            'email'                 => 'required|email|unique:users',
            'password'              => 'required|confirmed|min:6',   
            'password_confirmation' => 'required',   
            'photo'                 => 'mimes:jpg,png,jpeg,gif,bmp|nullable'
            ]
            );
           
            $user           = new User();
            $user->name     = strip_tags($request->name);
            $user->email    = $request->email;
            $user->status   = 'active';
            $user->password = Hash::make($request->password);

            $photo = $request->file('photo');
            $slug  = str_slug($request->name);

            if (isset($photo)) {
                //make unique name for image
                $currentDate = Carbon::now()->toDateString();
                $photoName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$photo->getClientOriginalExtension();
                //check logo directory
                if(!Storage::disk('public')->exists('users')){
                    Storage::disk('public')->makeDirectory('users');
                }
                $photo->storeAs('public/users/', $photoName);

            }

            $user->photo = isset($photoName) ? $photoName : NULL;
            $user->save();

            $role = $request->role;

            if (isset($role)) {
                $role_r = Role::where('id', '=', $role)->firstOrFail();          
                $user->assignRole($role_r);
            }

            activity()->causedBy(auth()->user())->log('Created a user successfully');   

            $this->helper->one_time_message('success', 'User Added Successfully');
            return redirect('users');
        }
        else
        {
            $this->helper->getPermissionErrorMessage();
            return redirect()->back();
        }
    }

    public function edit($id)
    {       //Check Auth and Permission
        if (Auth::check() && Auth::user()->hasPermissionTo('edit_user') || Auth::user()->id == $id)
        {
            $user  = User::findOrFail($id);
            $roles = Role::get();

            return view('admin.users.edit', compact('user', 'roles'));
        }
        else
        {
            $this->helper->getPermissionErrorMessage();
            return redirect()->back();
        }
    }

    public function profile($id)
    {       //Check Auth and Permission
        if (Auth::check() && Auth::user()->hasPermissionTo('view_user') || Auth::user()->id == $id)
            {
                $user  = User::findOrFail($id);
                $roles = Role::get();

                return view('admin.users.profile', compact('user', 'roles'));
            }
        else
            {
                $this->helper->getPermissionErrorMessage();
                return redirect()->back();
            }
    }

    public function update(Request $request, $id)
    {        //Check Auth and Permission
        if (Auth::check() && Auth::user()->hasPermissionTo('edit_user') || Auth::user()->id == $id)
        {
            $this->validate($request, [
            'name'     => 'required|max:255',
            'status'   => 'required',
            'email'    => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|min:6|confirmed',
            'role'     => 'required',
            'photo'    => 'image|mimes:png,jpg,jpeg,gif,bmp'
            ]
            );

            $user           = User::findOrFail($id);
            $user->name     = strip_tags($request->name);
            $user->email    = $request->email;
            $user->status   = $request->status;
            
            if (isset($request->password)) {
                $user->password = Hash::make($request->password);
            }

            $photo = $request->file('photo');
            $slug  = str_slug($request->name);

            if (isset($photo)) {

                $currentDate = Carbon::now()->toDateString();
                $photoName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$photo->getClientOriginalExtension();
                
                if (!Storage::disk('public')->exists('users')) {
                    Storage::disk('public')->makeDirectory('users');
                }

                if (Storage::disk('public')->exists('users/' . $user->photo)) {
                    Storage::disk('public')->delete('users/' . $user->photo);
                 }
                $photo->storeAs('public/users/', $photoName);

            } else {
                $photoName = $user->photo;
            }

            $user->photo = $photoName;

            $user->save();

            $role = $request->role;

            if (isset($role)) {
                $role_r = Role::where('id', '=', $role)->firstOrFail();
                $user->roles()->sync($role_r);
            }   

            activity()->causedBy(auth()->user())->log('Updated a user successfully'); 

            $this->helper->one_time_message('success', 'User Updated Successfully');
            return redirect('users');
        }
        else
        {
            $this->helper->getPermissionErrorMessage();
            return redirect()->back();
        }
    }

    public function destroy($id)
    {       //Check Auth and Permission
        
        if (Auth::check() && Auth::user()->hasPermissionTo('delete_user')) 
        {

            $user = User::findOrFail($id);
            $user->delete();

            if (Storage::disk('public')->exists('users/' . $user->photo)) {
                Storage::disk('public')->delete('users/' . $user->photo);
             }
            
            activity()->causedBy(auth()->user())->log('Deleted a user successfully'); 

            $this->helper->one_time_message('success', 'User Deleted Successfully');
            return redirect('users');
        }
        else
        {
            $this->helper->getPermissionErrorMessage();
            return redirect()->back();
        }

    }

    /* Email exists or not check (EmailUniqueCheck) */
    public function emailUniqueCheckOnAdd(Request $request)
    {
        
        $user = User::where(['email' => $request->email])->exists();
        
        if ($user) {
            $data['status']  = false;
            $data['fail']    = "Email has already been taken!";
        } else {
            $data['status']  = true;
            $data['success'] = "Email name is Available!";
        }
        return json_encode($data);
        
    }

    /* Email exists or not check (EmailUniqueCheck) */
    public function emailUniqueCheckOnUpdate(Request $request)
    {
        $user_id = base64_decode($request->user_id);
        
        $user = User::where(['email' => $request->email])
                ->where(function($query) use ($user_id)  
                {
                    $query->where('id', '!=', $user_id);
                })   
                ->exists();
        
        if ($user) {
            $data['status']  = false;
            $data['fail']    = "Email has already been taken!";
        } else {
            $data['status']  = true;
            $data['success'] = "Email name is Available!";
        }
        return json_encode($data);
        
    }

    /*----------  Registration User from frontend  ----------*/
    
    public function registration()
    {
        $registration = \DB::table('option_settings')->where('name', 'registration')->value('option');
        if (isset($registration)) {
            if($registration ==  'enable'){
                return view('auth.register');
           }
        }
        abort(403);
    }

    public function registrationStore(Request $request)
    {     
        $this->validate($request, [
            'name'                  => 'required',
            'email'                 => 'required|email|unique:users',
            'password'              => 'required|confirmed|min:6',   
            'password_confirmation' => 'required',   
            'photo'                 => 'mimes:jpg,png,jpeg,gif,bmp|nullable'
            ]
        );

        $user           = new User();
        $user->name     = $request->name;
        $user->email    = $request->email;

        /*----------  get user status dynamically  ----------*/
        $defaultStatus = DB::table('option_settings')->where('name', 'default-status')->value('option');
        if (!empty($defaultStatus)) {
            $user->status   = $defaultStatus;
        }

        $user->password = Hash::make($request->password);

        $photo = $request->file('photo');
        $slug  = str_slug($request->name);

        if (isset($photo)) {
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $photoName = $slug.'-'.$currentDate.'-'.uniqid().'.'.$photo->getClientOriginalExtension();
            //check logo directory
            if(!Storage::disk('public')->exists('users')){
                Storage::disk('public')->makeDirectory('users');
            }
            $photo->storeAs('public/users/', $photoName);

        }

        $user->photo = isset($photoName) ? $photoName : NULL;
        $user->save();
        

        $reg_mail_to = \DB::table('option_settings')->where('name', 'reg_mail_to')->value('option');
        $reg_mail_status = \DB::table('option_settings')->where('name', 'reg_mail_status')->value('option');

        if (isset($reg_mail_to)) {
            if ($reg_mail_status == 'enable') {
                Mail::to($reg_mail_to)->later(30, new RegisterMail($user));
            }
        }
        

        activity()->log('Register a user successfully');   

        $this->helper->one_time_message('success', 'User Added Successfully');
        return redirect('login')->withErrors(['Successfully SignUp']);;
    }
    
}
