<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LanguageRequest;
use App\Http\Requests\MainCategoryRequest;
use App\Models\Language;
use App\Models\Main_Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MainCategoriesController extends Controller
{
    public function index(){
        $default_lang = get_default_lang(); 
        $categories = Main_Category::where('translation_lang',$default_lang)->selection()->get();
        return view('admin.maincategories.index',compact('categories'));
    }

    public function create(){
        return view('admin.maincategories.create');
    }

    public function store(MainCategoryRequest $request){
       
        try{

            if(!$request->has('active')){
                $request->request->add(['active' => 0]);
            }
            $main_categories = collect($request->category);
            $filter = $main_categories->filter(function($value,$key){
                return $value['abbr'] === get_default_lang();
            });
            $default_category = array_values($filter->all())[0];
            $filePath = "";
            if($request->has('photo')){
                $filePath = uploadImage('maincategories',$request->photo);
            }
            
            DB::beginTransaction();
            $default_category_id = Main_Category::insertGetId([
                'name' => $default_category['name'],
                'translation_lang' => $default_category['abbr'],
                'translation_off' => 0,
                'slug' =>  $default_category['name'],
                'active' => $default_category['active'],
                'photo' => $filePath,
            ]);

            $categories = $main_categories->filter(function($value,$key){
                return $value['abbr'] !== get_default_lang();
            });
            $categories_arr=[];
            foreach($categories as $category){
                $categories_arr[] = [
                    'name' => $category['name'],
                    'translation_lang' => $category['abbr'],
                    'translation_off' => $default_category_id,
                    'slug' =>  $category['name'],
                    'active' => $category['active'],
                    'photo' => $filePath,
                ];
            }
            foreach($categories_arr as $category){
                Main_Category::create($category);
            }
            DB::commit();
            return redirect()->route('admin.maincategories')->with(['success' => 'تم اضافه قسم بنجاح.']);
        }
        catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('admin.maincategories')->with(['success' => 'هناك خطأ ما يرجو المحاوله تانيه.']);
        }
    }

    public function edit($id){
        $mainCategory  = Main_Category::selection()->find($id);
        if(!$mainCategory){
            return redirect()->route('admin.maincategories')->with(['error' =>'هذه قسم غير موجوده']);
        }
        return view('admin.maincategories.edit',compact('mainCategory'));
    }

    public function update(MainCategoryRequest $request , $id){
       
        try{
            if(!$request->has('active')){
                $request->request->add(['active' => 0]);
            }

            $category = Main_Category::with('categories')
                ->selection()
                ->find($id);
            if(!$category){
                return redirect()->route('admin.maincategories.edit')->with(['error' =>'هذه قسم غير موجوده']);
            }
            if(!$request->has('category.0.active')){
                $request->request->add(['active' => 0]);
            }else{
                $request->request->add(['active' => 1]);
            }

            $params = array_values($request->category)[0];
            Main_Category::where('id',$id)->first()->update([
                'name' => $params['name'],
                'active' =>$request->active,
            ]);

            if($request->has('photo')){
                $filePath = uploadImage('maincategories',$request->photo);
                Main_Category::where('id',$id)->first()->update([
                    'photo' =>$filePath,
                ]);
            }
            return redirect()->route('admin.maincategories')->with(['success' => 'تم تحديث قسم بنجاح.']);
        }
        catch(\Exception $e){

            return redirect()->route('admin.maincategories')->with(['error' => 'هناك خطأ ما يرجو المحاوله تانيه.']);
        } 
    }

    public function destory($id){
        try{
            DB::beginTransaction();
            $category = Main_Category::find($id);
            if(!$category){
                return redirect()->route('admin.maincategories')->with(['error' =>'هذه القسم غير موجوده']);
            }
            $vendors = $category->vendors()->get();
            if(isset($vendors) && $vendors->count() > 0){
                return redirect()->route('admin.maincategories')->with(['error' =>'لا يمكن حذف هذا القسم']);
            }

            $image = Str::after($category->photo,'assets/');
            $image = base_path('assets/'.$image); 
            unlink($image);
            $category->delete();
            DB::commit();
            return redirect()->route('admin.maincategories')->with(['success' => 'تم حذف القسم بنجاح.']);
        }
        catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('admin.maincategories')->with(['error' => 'هناك خطأ ما يرجو المحاوله تانيه.']);
        } 

    }

    public function changeStatus($id){
        try{
            DB::beginTransaction();
            $mainCategory = Main_Category::find($id);
            if(!$mainCategory){
                return redirect()->route('admin.maincategories')->with(['error' =>'هذه القسم غير موجوده']);
            }

            $mainCategory->active = !$mainCategory->active;
            $mainCategory->save();
           
            DB::commit();
            return redirect()->route('admin.maincategories')->with(['success' => 'تم تغير الحاله بنجاح.']);
        }
        catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('admin.maincategories')->with(['error' => 'هناك خطأ ما يرجو المحاوله تانيه.']);
        } 
    }

    
}
