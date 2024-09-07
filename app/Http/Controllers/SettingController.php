<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function Profile(Request $request) {
        $user = Auth::user();
        return view('page.setting.profile', ['user'=>$user]);
    }

    public function UpdateData(Request $request) {
        $user = Auth::user();
        $user = User::find($user->id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->address = $request->input('address');
        $user->username = $request->input('username');
        $user->phone_number = $request->input('phone_number');
        if($request->hasFile('image'))
        {
            $destination = 'uploads/users'. $user->image;
            if(User::exists($destination))
            {
                User::destroy($destination);
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); 
            $filename = time().'.'.$extension;
            $file->move('uploads/users', $filename);
            $user->image = $filename;
            
        }
        $user->save();
        return redirect()->route('account')->with('message', 'Update is successfully !');
    }

     // delete 
     public function DeleteAccount(Request $request){
        $user = Auth::user();
        try {
            User::destroy($user->id);
            return redirect()->route('sign-in');
        } catch(\Exception $e) {
            report($e);
        }
    }
}
