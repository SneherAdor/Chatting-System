<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Common;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Auth;

class RoleController extends Controller
{
    protected $helper;

    public function __construct()
    {
        $this->helper = new Common();
    }

    public function index()
    {       //Check Auth and Permission
        if (Auth::check() && Auth::user()->hasPermissionTo('view_role'))
        {
            $roles = Role::all();
            return view('admin.role.index')->with('roles', $roles);
        }
        else
        {
            $this->helper->getPermissionErrorMessage();
            return redirect()->back();
        }	
    }

    public function create()
    {       //Check Auth and Permission
        if (Auth::check() && Auth::user()->hasPermissionTo('create_role'))
        {
            $permissions = Permission::all();
            return view('admin.role.create', ['permissions'=>$permissions]);
        }
        else
        {
            $this->helper->getPermissionErrorMessage();
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {       //Check Auth and Permission
        if (Auth::check() && Auth::user()->hasPermissionTo('create_role'))
        {
            $this->validate($request, [
            'name'=>'required|unique:roles|max:10',
                ]
            ); 

            $name         = $request->name;
            $role         = new Role();
            $role->name   = $name;
            $role->save();

            $permissions  = $request->permissions;
            // dd($permissions);
            if (!is_null($permissions)) {
                foreach ($permissions as $permission) {
                    $p    = Permission::where('id', '=', $permission)->firstOrFail();
                    $role = Role::where('name', '=', $name)->first();
                    $role->givePermissionTo($p);
                }
            }

            activity()->causedBy(auth()->user())->log(__('controllers.create_role')); 

            $this->helper->one_time_message('success', __('controllers.create_role'));
            return redirect('roles');
        }
        else
        {
            $this->helper->getPermissionErrorMessage();
            return redirect()->back();
        }
    }

    public function edit($id)
    {       //Check Auth and Permission
        if (Auth::check() && Auth::user()->hasPermissionTo('edit_role'))
        {
            $role = Role::findOrFail($id);
            $permissions = Permission::all();
            return view('admin.role.edit', compact('role', 'permissions')); 
        }
        else
        {
            $this->helper->getPermissionErrorMessage();
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {            //Check Auth and Permission
        if (Auth::check() && Auth::user()->hasPermissionTo('edit_role'))
        {
            $role = Role::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|max:15|unique:roles,name,'.$id,
            ]);

            $input       = $request->except(['permissions']);
            $permissions = $request->permissions;
            $role->fill($input)->save();
            $p_all = Permission::all();
            
            foreach ($p_all as $p) {
                $role->revokePermissionTo($p);
            }
            
            if (!is_null($permissions)) {
                foreach ($permissions as $permission) {
                    $p = Permission::where('id', '=', $permission)->firstOrFail(); //Get corresponding form permission in db
                    $role->givePermissionTo($p);  
                }
            }

            activity()->causedBy(auth()->user())->log(__('controllers.update_role'));

            $this->helper->one_time_message('success', __('controllers.update_role'));
            return redirect('roles');
        }
        else
        {
            $this->helper->getPermissionErrorMessage();
            return redirect()->back();
        }
        
    }

    public function destroy($id)
    {       //Check Auth and Permission
        if (Auth::check() && Auth::user()->hasPermissionTo('delete_role'))
        {
            $role = Role::findOrFail($id);
            $role->delete();

            activity()
            ->causedBy(auth()->user())
            ->log(__('controllers.delete_role')); 
            $this->helper->one_time_message('success', __('controllers.delete_role'));
            return redirect('roles');
        }
        else
        {
            $this->helper->getPermissionErrorMessage();
            return redirect()->back();
        }
    }

    /* Role Name exists or not check (roleUniqueCheck) */
    public function roleUniqueCheckOnAdd(Request $request)
    {
        
        $role = Role::where(['name' => $request->role_name])->exists();
        
        if ($role) {
            $data['status']  = false;
            $data['fail']    = __('controllers.role_taken');
        } else {
            $data['status']  = true;
            $data['success'] = __('controllers.role_available');
        }
        return json_encode($data);
        
    }

    /* Role Name exists or not check (roleUniqueCheck) */
    public function roleUniqueCheckOnEdit(Request $request)
    {
        $role_name = $request->role_name;
        $role_id   = $request->role_id;
        // dd($role_id);
        
        $role  = Role::where(['name' => $role_name])
                ->where(function ($query) use ($role_id)
                {
                    $query->where('id', '!=', $role_id);
                })
                ->exists();

        if ($role) {
            $data['status']  = false;
            $data['fail']    = __('controllers.role_taken');
        } else {
            $data['status']  = true;
            $data['success'] = __('controllers.role_available');
        }
        return json_encode($data);
    }
}
