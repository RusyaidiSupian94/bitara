<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Staff extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('role')->whereHas('role', function ($role) {
            $role->whereIn('role_id', [1, 2]);
        })->get();

        return view('content.admin.settings.dashboards-staff', compact('users'));
    }

    public function add_staff(Request $request)
    {
        $user = User::with('user_details')->get();
        return view('content.admin.settings.add-staff', compact('user'));
    }

    public function save_staff(Request $request)
    {

        $user = User::factory()->create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        if ($request->role == 1) {
            $role = 1;
        } else {
            $role = 2;
        }

        $userrole = UserRole::create([
            'user_id' => $user->id,
            'role_id' => $role,
        ]);

        if ($userrole) {
            Session::flash('success', 'Successfully add new staff.');
            return redirect()->route('dashboard-staff');

        } else {
            Session::flash('error', 'Error adding new staff.');
            return redirect()->route('dashboard-staff');
        }
    }

    public function delete_staff(Request $request)
    {
        $data = UserRole::where('user_id', $request->staff_id)->delete();

        $user = User::find($request->staff_id)->delete();
        if ($user) {
            return true;
        }
    }

    public function edit_staff($id)
    {
        $user = User::with('role')->find($id);

        return view('content.admin.settings.edit-staff', compact('user'));
    }

    public function save_edited_staff(Request $request, $id)
    {

        $user = User::where('id', $id)->update([
            'username' => $request->username,
            'email' => $request->email,
        ]);
        if ($request->password) {
            $user = User::where('id', $id)->update([
                'password' => bcrypt($request->password),
            ]);

        }

        if ($request->role == 1) {
            $role = 1;
        } else {
            $role = 2;
        }

        $userrole = UserRole::where('user_id',$id)->update([
            'role_id' => $role,
        ]);

        if ($userrole) {
            Session::flash('success', 'Successfully update staff.');
            return redirect()->route('dashboard-staff');

        } else {
            Session::flash('error', 'Error updating staff.');
            return redirect()->route('dashboard-staff');
        }
    }

}
