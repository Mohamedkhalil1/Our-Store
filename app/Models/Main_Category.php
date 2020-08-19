<?php

namespace App\Models;

use App\Observers\MainCategoryObserver;
use Illuminate\Database\Eloquent\Model;

class Main_Category extends Model
{
    protected $fillable = [
        'translation_lang', 'translation_off', 'name','address','slug','photo','active','created_at','update_at'
    ];


    protected static function boot(){
        parent::boot();
        Main_Category::observe(MainCategoryObserver::class);
    }
    public function scopeActive($query){
        return $query->where('active',1);
    }
    
    public function scopeSelection($query){
       return $query->select('id','translation_lang','translation_off','name','slug','photo','active');
    }

    public function getPhotoAttribute($value){
        return ($value !== null) ? asset('assets/'.$value): "";
    }

    public function getActive(){
        return   $this -> active == 1 ? 'مفعل'  : 'غير مفعل';
    }

    public function categories(){
        return $this->hasMany(self::class,'translation_off');
    }

    public function vendors(){
        return $this->hasMany(Vendor::class,'category_id');
    }

}
