<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LanguageRequest;
use App\Http\Requests\VendorRequest;
use App\Models\Language;
use App\Models\Main_Category;
use App\Models\Vendor;
use App\Notifications\VendorCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class VendorsController extends Controller
{
    public function index(){
        
        $vendors = Vendor::selection()->paginate(PAGINATION_COUNT);
        
        return view('admin.vendors.index',compact('vendors'));
    }

    public function create(){
        $categories = Main_Category::active()->where('translation_lang',get_default_lang())->get();
        return view('admin.vendors.create',compact('categories'));
    }

    public function store(VendorRequest $request){
      
        try{

            if(!$request->has('active')){
                $request->request->add(['active' => 0]);
            }
            $filePath ="";
            if($request->has('logo')){
                $filePath = uploadImage('vendors',$request->logo);
                $request->request->add(['logo' => $filePath]);
            }
           
            $request->password = bcrypt($request->password);
            $params = $request->except(['_token']);
            //dd($params);
            $vendor = Vendor::create([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'active' => $request->active,
                'address' => $request->address,
                'logo' => $filePath,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude
            ]);
            
          //  Notification::send($vendor->email,new VendorCreated($vendor));
            return redirect()->route('admin.vendors')->with(['success' => 'تم اضافه متجر بنجاح.']);
        }
        catch(\Exception $e){
            return $e; 
            return redirect()->route('admin.vendors')->with(['error' => 'هناك خطأ ما يرجو المحاوله تانيه.']);
        } 
    }

    public function edit($id){
        $vendor = Vendor::find($id);
        
        if(!$vendor){
            return redirect()->back()->with(['error' =>'هذه المتجر غير موجوده']);
        }
        $categories = Main_Category::active()->where('translation_lang',get_default_lang())->get();
        return view('admin.vendors.edit',compact('vendor','categories'));
    }

    public function update(VendorRequest $request , $id){

        try{
            $vendor = Vendor::find($id);
            if(!$vendor){
                return redirect()->route('admin.vendors.edit')->with(['error' =>'هذه اللغه غير موجوده']);
            }
            if(!$request->has('active')){
                $request->request->add(['active' => 0]);
            }

            DB::beginTransaction();
            
            if($request->has('logo')){
                $filePath = uploadImage('vendors',$request->logo);
                Vendor::where('id',$id)->first()->update([
                    'logo' =>$filePath,
                ]);
            }

            $password = $vendor->password;
             if($request->has('password') && $request->get('password') !== null){
               $password = bcrypt($request->password);
            }
            $vendor->name= $request->name;
            $vendor->category_id= $request->category_id;
            $vendor->mobile= $request->mobile;
            $vendor->email= $request->email;
            $vendor->active=$request->active;
            $vendor->address=$request->address;
            $vendor->latitude = $request->latitude;
            $vendor->longitude = $request->longitude;
            
            $vendor->save();
            DB::commit();
            return redirect()->route('admin.vendors')->with(['success' => 'تم تحديث المتجر بنجاح.']);
        }
        catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('admin.vendors')->with(['error' => 'هناك خطأ ما يرجو المحاوله تانيه.']);
        } 
    }

    public function destory($id){
        try{
            $vendor = Vendor::find($id);
            if(!$vendor){
                return redirect()->route('admin.vendors')->with(['error' =>'هذه البائع غير موجود']);
            }
            $vendor->delete();
            $logo = Str::after($vendor->logo,'assets/');
            $logo = base_path('assets/'.$logo); 
            unlink($logo);
            return redirect()->route('admin.vendors')->with(['success' => 'تم حذف البائع بنجاح.']);
        }
        catch(\Exception $e){
            return redirect()->route('admin.vendors')->with(['success' => 'هناك خطأ ما يرجو المحاوله تانيه.']);
        } 

    }

    public function changeStatus($id){
        try{
            DB::beginTransaction();
            $vendor = Vendor::find($id);
            if(!$vendor){
                return redirect()->route('admin.vendors')->with(['error' =>'هذه المتجر غير موجوده']);
            }

            $vendor->active = !$vendor->active;
            $vendor->save();
           
            DB::commit();
            return redirect()->route('admin.vendors')->with(['success' => 'تم تغير الحاله بنجاح.']);
        }
        catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('admin.vendors')->with(['error' => 'هناك خطأ ما يرجو المحاوله تانيه.']);
        }
    } 
}
