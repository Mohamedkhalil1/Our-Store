<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::orderBy('id','desc')->paginate(PAGINATION_COUNT);
        return view('admin.brands.index',compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {
        try{
            DB::beginTransaction();
            //update 
            if(!$request->has('is_active')){
                $request->request->add(['is_active'=>0]);
            }else{
                $request->request->add(['is_active'=>1]);
            }
            
            $filePath = '';
            if($request->has('photo')){
                $filePath = uploadImage('brands',$request->photo);
            }
             $params = $request->except('_token','photo');
             $params['photo'] = $filePath;

            $brand = Brand::create($params);
            $brand->name= $params['name'];
            $brand->save();

            DB::commit();
            return redirect()->route('admin.brands')->with(['success' => 'تم الاضافه بنجاح']);
        }catch(Exception $ex){
            dd($ex);
            DB::rollback();
            return redirect()->back()->with(['error' => 'حدث خطأ']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = Brand::find($id);
        if($brand === null){
            return redirect()->route('admin.brands')->with(['error' => 'هذه الماركه غير موجوده']);
        };
        return view('admin.brands.edit',compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validate 
        try{
            DB::beginTransaction();
            //update 
            if(!$request->has('is_active')){
                $request->request->add(['is_active'=>0]);
            }else{
                $request->request->add(['is_active'=>1]);
            }
            $brand = Brand::find($id);
            if(!$brand){
                return redirect()->back()->with(['error' => 'هذا الماركه غير موجوده']);
            }
            $params = $request->except('_token','id','photo');
            $filePath = '';
            if($request->has('photo')){
                if($brand->photo !== null){
                    $image = str_replace(url(''),'',$brand->photo);
                    $image = base_path($image); 
                    unlink($image);
                }
                $filePath = uploadImage('brands',$request->photo);
                $params['photo'] = $filePath;
            }
            $brand->update($params);
            $brand->name= $params['name'];
            $brand->save();
            DB::commit();
            return redirect()->route('admin.brands')->with(['success' => 'تم التحديث بنجاح']);
        }catch(Exception $ex){
            dd($ex);
            DB::rollback();
            return redirect()->back()->with(['error' => 'حدث خطأ']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{            
            $brand = Brand::find($id);
            if(!$brand){
                return redirect()->back()->with(['error' => 'هذه الماركه غير موجوده']);
            }
            $brand->delete();
            if($brand->photo !== null){
                $image = str_replace(url(''),'',$brand->photo);
                $image = base_path($image); 
                unlink($image);
            }
            return redirect()->route('admin.brands')->with(['success' => 'تم حذف الماركه بنجاح']);
        }catch(Exception $ex){
            dd($ex);
            return redirect()->back()->with(['error' => 'حدث خطأ']);
        }
    }
}
