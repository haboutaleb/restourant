<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Back\CreateAdminRequest;
use App\Http\Requests\Back\EditAdminRequest;
use App\Models\Admin;
use App\Models\User;
use Auth, DB, Image, File, Validator, Response, Hash;

class AdminController extends Controller
{
	public function index()
	{
        $admins = Admin::get();
        return view('Back.admins.index', compact('admins'));
	}

	public function home()
	{
		return view('Back.index');
	}

    public function Trashed()
    {
        $admins = Admin::onlyTrashed()->get();
        return view('Back.admins.trashed', compact('admins'));
    }

    public function create()
    {
        return view('Back.admins.create');
    }

    public function store(CreateAdminRequest $request)
    {
        $adminData = $request->all();

        if(Admin::createAdmin(array_except($adminData, ['_token', 'password_confirmation'])))
        {
            if (request()->ajax()) {
                return response()->json(['requestStatus' => true, 'message' => __('Data Added Successfully')]);
            } else {
                request()->session()->flash('status','success');
                request()->session()->flash('message',__('Data Added Successfully'));
            }
        }
        else
        {
            if(request()->ajax()) {
                return response()->json(['requestStatus' => false, 'message' => __('Internal Server Error 500')]);
            } else {
                request()->session()->flash('status','danger');
                request()->session()->flash('message',__('Internal Server Error 500'));
            }

            return back()->withInputs();
        }
        return redirect()->route('admins.index');
    }

    public function ChangeAdminStatus(Request $request)
    {
        // Request ajax from index;
        $adminData = $request->all();
        $currentAdmin = Admin::find($request->id);
        
        if (!$updateAdminStatus = Admin::updateAdminStatus($adminData, $currentAdmin))
            return response()->json(['requestStatus' => false, 'message' => trans('Server Internal Error 500')]);

        return response()->json(['requestStatus' => true, 'message' => trans('Data Updated Successfully')]);
    }

    public function edit($id)
    {
        $admin = Admin::find($id);
        return view('Back.admins.edit', compact('admin'));
    }

    public function update(EditAdminRequest $request, $id)
    {
        $adminData = $request->all();
        $currentAdmin = Admin::find($id);
        
        if (Admin::updateAdmin($adminData, $currentAdmin)) {

            if (request()->ajax()) {
                return response()->json(['requestStatus' => true, 'message' => __('Data Updated Successfully')]);
            }else{
                request()->session()->flash('status','success');
                request()->session()->flash('message',__('Data Updated Successfully'));
            }
        }else{
            if (request()->ajax()) {
                return response()->json(['requestStatus' => false, 'message' => __('Server Internal Error 500')]);
            }else{
                 request()->session()->flash('status','danger');
                 request()->session()->flash('message',__('Server Internal Error 500'));
            }
        }

        return redirect()->route('admins.edit', ['id' => $currentAdmin->id]);
    }

    public function DeleteAdmin(Request $request)
    {
        $admin = Admin::find($request->id);

        if(!$admin) return response()->json(['deleteStatus' => false, 'error' => 'Sorry, Admin is not exists !!']);

        try
        {            
            $admin->delete();
            
            return response()->json(['deleteStatus' => true, 'message' => 'Admin Deleted Successfully']);
        }
        catch (Exception $e){ return response()->json(['deleteStatus' => false,'error' => 'Server Internal Error 500']); }

        return redirect()->route('admins.index');
    }

    public function RestoreAdmin(Request $request)
    {
        $restore = DB::table('admins')->where('id', $request->id)->where('deleted_at', '!=', null)->update(['deleted_at' => null]);
        
        $response['requestStatus']  = ($restore) ? true : false;
        $response['message']        = ($restore) ? 'Admin Restored Successfully' : 'Server Internal Error 500';

        return response()->json($response);
    }

    public function RemoveAdmin(Request $request)
    {
        $remove = DB::table('admins')->where('id', $request->id)->where('deleted_at', '!=', null);

        if (isset($remove->image) && $remove->image != null) File::delete('uploaded/admins/'.$remove->image);

        $remove->delete();
        
        $response['requestStatus']  = ($remove) ? true : false;

        return response()->json($response);
    }
}
