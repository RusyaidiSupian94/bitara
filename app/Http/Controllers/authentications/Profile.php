<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class Profile extends Controller
{
    public function index(Request $request, $id)
    {
        $user = User::with('user_details')->find($id);
        $states = State::all();

        return view('content.authentications.update-profile', compact('user', 'states'));
    }
    public function save(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        if (Hash::check($request->old_password, $user->password)) {

            $userupdate = User::where('id', $user->id)->update([
                'password' => bcrypt($request->password),
            ]);

            $user_details = UserDetail::where('user_id', $user->id)->update([
                'fname' => $request->fname,
                'lname' => $request->lname,
                'address_1' => $request->address_1,
                'address_2' => $request->address_2,
                'postcode' => $request->postcode,
                'state_id' => $request->state,
                'email_address' => $request->email,
            ]);

            Session::flash('success', 'Successfully update user profile.');
            return redirect()->route('update-profile', ['id' => $user->id]);

        } else {
            Session::flash('error', 'Error updating user profile.');
            return redirect()->route('update-profile', ['id' => $user->id]);
        }
    }
}
