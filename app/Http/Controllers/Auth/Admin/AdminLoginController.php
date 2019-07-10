<?php

namespace App\Http\Controllers\Auth\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class AdminLoginController extends Controller
{
    use AuthenticatesUsers;
    
	public function __construct()
	{
		$this->middleware('guest:admin')->except('adminLogout');
	}

    public function showAdminLoginForm()
    {
        return view('auth.admin.login');
    }

    public function adminLogin(Request $request)
    {
        $validation['email']    = 'required|email';
        $validation['password'] = 'required|string|min:6';

        $credentials['email']    = $request->email;
        $credentials['password'] = $request->password;
        $credentials['status']   = 1;
        
        $this->validate($request, $validation);

        if (Auth::guard('admin')->attempt($credentials)) {

            return redirect()->intended('/admin-panel');
        }
        return back()->withInput($request->only('email'));
    }

    public function adminLogout()
    {
        Auth::guard('admin')->logout();
 
        return redirect('/admin-panel');
    }
}
