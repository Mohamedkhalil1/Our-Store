<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shipping\ShippingRequest;
use App\Models\Settings;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function editShippingMethod($type){
        // type is free , inner , outer 

        if($type === 'free'){
            $shippingMethod = Settings::where('key',"free_shipping_label")->first();
        }elseif($type === 'inner'){
            $shippingMethod =  Settings::where('key',"local_label")->first();
        }elseif($type === 'outer'){
            $shippingMethod =  Settings::where('key',"outer_label")->first();
        }else{
            $shippingMethod =  Settings::where('key',"free_shipping_label")->first();
        }
        
        return view('admin.settings.shipping.edit',compact('shippingMethod'));
        
    }

    public function updateShippingMethod($id,ShippingRequest $request){

        try{
            DB::beginTransaction();
            $params = $request->except('_token','value');
            $setting = Settings::find($id);
            $setting->update($params);
            $setting->value = $request->value;
            $setting->save();
            DB::commit();
            return redirect()->back()->with(['success' => 'تم التحديث بنجاح']);
        }catch(Exception $ex){
            DB::rollBack();
            return redirect()->back()->with(['fail' => 'حدث خطأ']);
        }
    }
}
