<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryReuest;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type)
    {
        if($type === TYPE){
            $categories = Category::parent()->orderBy('id','desc')->paginate(PAGINATION_COUNT); 
        }else{
            $categories = Category::child()->orderBy('id','desc')->paginate(PAGINATION_COUNT);
        }
        return view('admin.categories.index',compact('categories','type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        $categories = Category::parent()->get();
        return view('admin.categories.create',compact('categories','type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MainCategoryReuest $request)
    {
        try{
            DB::beginTransaction();
            //update 
            if(!$request->has('is_active')){
                $request->request->add(['is_active'=>0]);
            }else{
                $request->request->add(['is_active'=>1]);
            }
            
            $params = $request->except('_token');
            $category = Category::create($params);
            $category->name= $params['name'];
            $category->save();
            $type = $request->type;
            DB::commit();
            
            return redirect('admin/categories/'.$type)->with(['success' => 'تم الاضافه بنجاح']);
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
    public function edit($id,$type)
    {
        $category = Category::find($id);
        $categories = Category::parent()->get();
        return view('admin.categories.edit',compact('category','categories','type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MainCategoryReuest $request, $id)
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
            $category = Category::find($id);
            if(!$category){
                return redirect()->back()->with(['fail' => 'هذا القسم غير موجود']);
            }
            $params = $request->except('_token','id');
            $category->update($params);
            $category->name= $params['name'];
            $category->save();
            $type=$request->type;
            DB::commit();
            return redirect('admin/categories/'.$type)->with(['success' => 'تم التحديث بنجاح']);
        }catch(Exception $ex){
            dd($ex);
            DB::rollback();
            return redirect()->back()->with(['fail' => 'حدث خطأ']);
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
            $category = Category::find($id);
            if(!$category){
                return redirect()->back()->with(['fail' => 'هذا القسم غير موجود']);
            }
            $category->delete();
            return redirect()->route('admin.maincategories.index')->with(['success' => 'تم حذف القسم بنجاح']);
        }catch(Exception $ex){
            return redirect()->back()->with(['fail' => 'حدث خطأ']);
        }
    }
}
