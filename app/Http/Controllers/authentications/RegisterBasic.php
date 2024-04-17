<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\Request;

class RegisterBasic extends Controller
{
  public function index()
  {

    $states = State::all();
    return view('content.authentications.auth-register-basic', compact('states'));
  }
}
