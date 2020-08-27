<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;

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

    public function updateShippingMethod($id,Request $request){
        return $request;
    }
}
