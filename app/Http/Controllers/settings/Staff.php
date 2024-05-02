<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;

class Staff extends Controller
{
    public function index(Request $request)
    {
     
        return view('content.admin.settings.dashboards-staff');
    }
    
    public function add_staff(Request $request)
    {
        $user = User::with('user_details')->get();
        $states = State::all();

        return view('content.admin.settings.add-staff', compact('user', 'states'));
    }

}
