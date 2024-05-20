<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Debug\Dumper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
class RegisterBasic extends Controller
{
  public function index()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-register-basic', ['pageConfigs' => $pageConfigs]);
  }

  public function validateform_register(Request $req)
  {
    $validator = Validator::make($req->all(), [
      'username' => 'required|unique:users',
      'first_name' => 'required',
      'last_name' => 'required',
      'phone_no' => 'required|unique:users',
      'email' => 'required|email|unique:users',
      'password' => [
        'required',
        'string',
        Password::min(8)
          ->letters()
          ->numbers()
          ->mixedCase()
          ->symbols(),
      ],
      'confirm_password' => 'required|same:password',
    ]);
    if ($validator->passes()) {
      $user = new User();
      $user->username = $req->username;
      $user->first_name = $req->first_name;
      $user->last_name = $req->last_name;
      $user->phone_no = $req->phone_no;
      $user->email = $req->email;
      $user->password = Hash::make($req->password);
      $user->assignRole('User');
      $user->save();

      return response()->json(['success' => 'New Account Create Successfully']);
    }
    return response()->json(['error' => $validator->errors()]);
  }
}
