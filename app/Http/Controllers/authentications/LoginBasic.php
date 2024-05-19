<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginBasic extends Controller
{
    public function index()
    {
        return view('content.authentications.auth-login-basic');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');

        // Check if the user is an administrator
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $user = User::with('role')->find(Auth::id());
            $role = $user->role ? $user->role->role_id : null;
            // Redirect based on the user's role using switch-case
            switch ($role) {
                case 1:
                    // Admin user
                    return redirect()->route('dashboard-analytics');
                    break;
                case 2:
                    //staff
               return redirect()->route('dashboard-order');

                    break;
                case 3:
                    return redirect()->route('dashboard-customer');

                    break;
                default:
                    // Handle other roles as needed
                    return redirect()->route('auth-login-basic')->with('error', 'Invalid user role.');
            }
        } else {
            // Authentication failed...
            return redirect()->route('auth-login-basic')->with('error', 'Login failed. Please check your credentials.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        return redirect('/');
    }
}
