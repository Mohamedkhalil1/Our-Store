<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\Admin;
use Exception;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function editProfile(){
        $admin = Admin::find( auth('admin')->user()->id);
        
        return view('Admin.Profile.edit',compact('admin'));
    }

    public function updateProfile(ProfileRequest $request){
        // validate 

        //dp
        try{
           
            $params = $request->except('_token','1','_method','password','password_confirmation');
           
            if($request->filled('password')){
                $params['password'] = bcrypt($request->password);
            }
            $admin = Admin::find(auth()->user()->id);
            $admin->update($params);
          
            return redirect()->back()->with(['success' => 'تم التحديث بنجاح']);
        }catch(Exception $ex){
            return redirect()->back()->with(['fail' => 'حدث خطأ']);
        }
    }
}
