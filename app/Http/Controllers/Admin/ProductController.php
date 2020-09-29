<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralProductReuest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(PAGINATION_COUNT);
        return view('admin.products.general.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['brands'] = Brand::active()->select('id')->get();
        $data['tags'] = Tag::select('id')->get();
        $data['categories'] = Category::active()->select('id')->get();
    
        return view('admin.products.general.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GeneralProductReuest $request)
    {
        try{
            DB::beginTransaction();
            //update 
            if(!$request->has('is_active')){
                $request->request->add(['is_active'=>0]);
            }else{
                $request->request->add(['is_active'=>1]);
            }
            
          
            $product = Product::create([
                'slug' => $request->slug,
                'brand_id' => $request->brand_id,
                'is_active' => $request->is_active
            ]);
            $product->name= $request->name;
            $product->description= $request->description;
            $product->short_description= $request->short_description;
            $product->save();
            
            // save product with categories relations
            $product->categories()->attach($request->categories); 
            // end relation

            // save product with tags relations
            $product->tags()->attach($request->tags); 
              // end relation

            DB::commit();
            return redirect()->route('admin.products')->with(['success' => 'تم الاضافه بنجاح']);
        }catch(Exception $ex){
            dd($ex);
            DB::rollback();
            return redirect()->back()->with(['error' => 'حدث خطأ']);
        }
    }

}
