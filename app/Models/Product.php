<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use Translatable , SoftDeletes;

    protected $with = ['translations'];

    protected $guarded =[];

    protected $translatedAttributes = ['name','description','short_description'];

    protected $hidden = ['translations'];

    protected $casts = [
        'in_stock' => 'boolean',
        'is_active' => 'boolean',
        'manage_stock' => 'boolean'
    ];

    protected $dates = [
        'special_price_start',
        'special_price_end',
        'end_date',
        'start_date',
        'deleted_at'
    ];

    public function brand(){
        return $this->belongsTo(Brand::class,'brand_id')->withDefault();
    }

    public function categories(){
        return $this->belongsToMany(Category::class,'product_categories','product_id','category_id');
    }

    public function tags(){
        return $this->belongsToMany(Tag::class,'product_tags','product_id','tag_id');
    }

}
