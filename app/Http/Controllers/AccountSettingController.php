<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserInfo;

class AccountSettingController extends Controller
{
    public function AccountSetting() {
        $user_id = Auth::id();
        $user_info = UserInfo::where('user_id', $user_id)->first(); 
        return view('page.setting.profile', ['user_info'=>$user_info]);
    }

    public function DataInsert(Request $request) {
        $user_info = new UserInfo();
        $user_info->name = $request->input("name");
        $user_info->email = $request->input("email");
        $user_info->date_birth = $request->input("date_birth");;
        $user_info->gender = $request->input("gender");
        $user_info->phone_number = $request->input("phone_number");
        $user_info->address = $request->input("address");
        $user_info->about_me = $request->input("about_me");
        $user_info->user_id = Auth::id();
        
        $user_info->save();
        
        return redirect()->route('account-setting')->with('message','Update Setting Successfully');
    }
    
    public function DataUpdateAccountSetting(Request $request, $id) {
        $user_info = UserInfo::find($id);
        $user_info->name = $request->input("name");
        $user_info->email = $request->input("email");
        $user_info->date_birth = $request->input("date_birth");
        $user_info->gender = $request->input("gender");
        $user_info->phone_number = $request->input("phone_number");
        $user_info->address = $request->input("address");
        $user_info->about_me = $request->input("about_me");
        $user_info->user_id =  Auth::id();
        
        $user_info->update();
        
        return redirect()->route('account-setting')->with('message','Update Setting Successfully');
    }



    public function ClearUserInfo(Request $request, $id){
        try {   
            UserInfo::destroy($request->id);
            return redirect()->route('account-setting');
        } catch(\Exception $e) {
            report($e);
        }
    }
}
