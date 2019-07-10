<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Models\User;
use Auth, DB, Image, File, Validator, Response, Hash;

class UserController extends Controller
{
	public function index()
	{
		//
	}

    public function create()
    {
        return view('Backend.users.create');
    }

    public function store(CreateUserRequest $request)
    {
        $userData = $request->all();

        if(User::createUser(array_except($userData, ['_token', 'password_confirmation'])))
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
        return redirect()->route('users.index');
    }

    public function ChangeUserStatus(Request $request)
    {
        // Request ajax from index;
        $userData = $request->all();
        $currentUser = User::find($request->id);
        
        if (!$updateUserStatus = User::updateUserStatus($userData, $currentUser))
            return response()->json(['requestStatus' => false, 'message' => trans('Server Internal Error 500')]);

        return response()->json(['requestStatus' => true, 'message' => trans('Data Updated Successfully')]);
    }

    public function edit($id)
    {
        $user = User::find($id);
        $lists['cities'] = City::getInSelectForm();
        $lists['departments'] = Department::getInSelectForm();
        return view('Backend.users.edit', compact('user', 'lists'));
    }

    public function update(EditUserRequest $request, $id)
    {
        $userData = $request->all();
        $currentUser = User::find($id);
        
        if (User::updateUser($userData, $currentUser) ) {

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

        return redirect()->route('users.edit', ['id' => $currentUser->id]);
    }

    public function DeleteUser(Request $request)
    {
        $user = User::find($request->id);

        if(!$user) return response()->json(['deleteStatus' => false, 'error' => 'Sorry, User is not exists !!']);

        try
        {            
            $user->delete();
            
            return response()->json(['deleteStatus' => true, 'message' => 'User Deleted Successfully']);
        }
        catch (Exception $e){ return response()->json(['deleteStatus' => false,'error' => 'Server Internal Error 500']); }

        return redirect()->route('users.index');
    }

    public function RestoreUser(Request $request)
    {
        $restore = DB::table('users')->where('id', $request->id)->where('deleted_at', '!=', null)->update(['deleted_at' => null]);
        
        $response['requestStatus']  = ($restore) ? true : false;
        $response['message']        = ($restore) ? 'User Restored Successfully' : 'Server Internal Error 500';

        return response()->json($response);
    }

    public function RemoveUser(Request $request)
    {
        $remove = DB::table('users')->where('id', $request->id)->where('deleted_at', '!=', null);

        if (isset($remove->image) && $remove->image != null) File::delete('uploaded/users/'.$remove->image);

        $remove->delete();
        
        $response['requestStatus']  = ($remove) ? true : false;

        return response()->json($response);
    }
}
