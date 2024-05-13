<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\State;
use App\Models\User;
use App\Models\Postcode;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class Profile extends Controller
{
    public function index(Request $request, $id)
    {
        $user = User::with('role','user_details')->find($id);

        $states = State::all();
        $districts = District::all();
        $postcodes = Postcode::all();

        return view('content.authentications.update-profile', compact('user', 'states', 'districts', 'postcodes'));
    }
    public function save(Request $request)
    {
        $user = Auth::user();
        if ($request->old_password) {
            if (Hash::check($request->old_password, $user->password)) {

                $userupdate = User::where('id', $user->id)->update([
                    'password' => bcrypt($request->password),
                ]);
            }
        }

        $user_details = UserDetail::where('user_id', $user->id)->update([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'postcode' => $request->postcode,
            'district_id' => $request->district,
            'state_id' => $request->state,
            'postcode' => $request->postcode,
            'district_id' => $request->district,
            'email_address' => $request->email,
            'contact_no' => $request->contact_no,
        ]);

        if ($user_details) {

            Session::flash('success', 'Successfully update user profile.');
            return redirect()->route('update-profile', ['id' => $user->id]);
        } else {
            Session::flash('error', 'Error updating user profile.');
            return redirect()->route('update-profile', ['id' => $user->id]);
        }
    }
    public function get_profile_poscode_details(Request $request)
    {
        $postcode = Postcode::with('state', 'district')->find($request->postcode);
        return $postcode;
    }
}
