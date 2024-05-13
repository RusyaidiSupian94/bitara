<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\Postcode;
use App\Models\State;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserRole;
use Illuminate\Http\Request;

class RegisterBasic extends Controller
{
    public function index()
    {
        $postcodes = Postcode::all();
        // $stadistes = State::all();
        return view('content.authentications.auth-register-basic', compact('postcodes'));
    }

    public function registerCustomer(Request $request)
    {

        // dd($request->all());

        $request->validate([
            'password' => 'required|min:5',
            'confirm_password' => 'required|same:password',
        ]);
        $user = User::factory()->create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $userdetail = UserDetail::create([
            'user_id' => $user->id,
            'fname' => $request->fname,
            'lname' => $request->lname,
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'postcode' => $request->postcode,
            'district_id' => $request->district,
            'state_id' => $request->state,
            'email_address' => $request->email,
            'contact_no' => $request->contact_no,
        ]);

        $userrole = UserRole::create([
            'user_id' => $user->id,
            'role_id' => 3, // default 3 for customer only
        ]);

        return redirect()->route('auth-login-basic');
    }

    public function get_poscode_details(Request $request)
    {
        $postcode = Postcode::with('state', 'district')->find($request->postcode);
        return $postcode;
    }
}
