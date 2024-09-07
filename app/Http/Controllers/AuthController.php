<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User;
class AuthController extends Controller
{
   public function SignIn() {
      return view('auth.login');
   }

   public function SignUp() {
      return view('auth.register');
   }

   public function ForgotPass() {
      return view('auth.forgot-password');
   }

}
