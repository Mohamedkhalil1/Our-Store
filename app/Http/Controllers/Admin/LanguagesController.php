<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LanguageRequest;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguagesController extends Controller
{
    
    public function index(){
        
        $languages = Language::selection()->paginate(PAGINATION_COUNT);
        
        return view('admin.languages.index',compact('languages'));
    }

    public function create(){
        return view('admin.languages.create');
    }

    public function store(LanguageRequest $request){
       
        try{
            if(!$request->has('active')){
                $request->request->add(['active' => 0]);
            }
            $params = $request->except(['_token']);
            Language::create($params);
            
            return redirect()->route('admin.languages')->with(['success' => 'تم اضافه اللغه بنجاح.']);
        }
        catch(\Exception $e){
            return redirect()->route('admin.languages')->with(['error' => 'هناك خطأ ما يرجو المحاوله تانيه.']);
        } 
    }

    public function edit($id){
        $language = Language::find($id);
        if(!$language){
            return redirect()->back()->with(['error' =>'هذه اللغه غير موجوده']);
        }
        return view('admin.languages.edit',compact('language'));
    }

    public function update(LanguageRequest $request , $id){

        try{
            $language = Language::find($id);
            if(!$language){
                return redirect()->route('admin.languages.edit')->with(['error' =>'هذه اللغه غير موجوده']);
            }
            if(!$request->has('active')){
                $request->request->add(['active' => 0]);
            }
            $params = $request->except(['_token']);

            $language->update($params);
            return redirect()->route('admin.languages')->with(['success' => 'تم تحديث اللغه بنجاح.']);
        }
        catch(\Exception $e){
            return redirect()->route('admin.languages')->with(['error' => 'هناك خطأ ما يرجو المحاوله تانيه.']);
        } 
    }

    public function destory($id){
        try{
            $language = Language::find($id);
            if(!$language){
                return redirect()->route('admin.languages.edit')->with(['error' =>'هذه اللغه غير موجوده']);
            }
            $language->delete();
            return redirect()->route('admin.languages')->with(['success' => 'تم حذف اللغه بنجاح.']);
        }
        catch(\Exception $e){
            return redirect()->route('admin.languages')->with(['error' => 'هناك خطأ ما يرجو المحاوله تانيه.']);
        } 

    }

}
