<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Validator;
use App\Models\{Category};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Debug\Dumper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;

class LoginBasic extends Controller
{
  public function index()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-login-basic', ['pageConfigs' => $pageConfigs]);
  }

  public function validateform(Request $request)
{
  $field = filter_var($request->input('email-username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

  $validator = Validator::make($request->all(), [
      'email-username' => 'required',
      'password' => 'required'
  ]);

  if ($validator->fails()) {
    return response()->json(['error' => 'Please enter valid credentials.']);
  }

  $credentials = [
      $field => $request->input('email-username'),
      'password' => $request->input('password')
  ];

  if (Auth::attempt($credentials)) {
    return response()->json(['success' => 'Logged in successfully']);
  }

  return response()->json(['error' => 'Oops! It seems like you don\'t have an account or your email or password is invalid.']);
}

 public function logout(){
  // Session::flush();
  Auth::logout();
  return redirect('/auth/login-basic');

}



}
