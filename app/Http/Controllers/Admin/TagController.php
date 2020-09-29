<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Models\Tag;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::orderBy('id','desc')->paginate(PAGINATION_COUNT);
        return view('admin.tags.index',compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        try{
            DB::beginTransaction();
            
            $params = $request->except('_token','photo');
        
            $tag = Tag::create($params);
            $tag->name= $params['name'];
            $tag->save();

            DB::commit();
            return redirect()->route('admin.tags')->with(['success' => 'تم الاضافه بنجاح']);
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
        $tag = Tag::find($id);
        if($tag === null){
            return redirect()->route('admin.brands')->with(['error' => 'هذه التاج غير موجوده']);
        };
        return view('admin.tags.edit',compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, $id)
    {
        //validate 
        try{
            DB::beginTransaction();
            //update 
            $tag = Tag::find($id);
            if(!$tag){
                return redirect()->back()->with(['error' => 'هذا التاج غير موجوده']);
            }
            $params = $request->except('_token','id');
            
            $tag->update($params);
            $tag->name= $params['name'];
            $tag->save();
            DB::commit();
            return redirect()->route('admin.tags')->with(['success' => 'تم التحديث بنجاح']);
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
            $tag = tag::find($id);
            if(!$tag){
                return redirect()->back()->with(['error' => 'هذه التاج غير موجوده']);
            }
            $tag->delete();
            $tag->translations()->delete();
            return redirect()->route('admin.tags')->with(['success' => 'تم حذف الماركه بنجاح']);
        }catch(Exception $ex){
            dd($ex);
            return redirect()->back()->with(['error' => 'حدث خطأ']);
        }
    }
}
