<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use PDO;

class Vendor extends Model
{
    use Notifiable;
    protected $fillable = [
        'name', 'mobile', 'address','email','category_id','logo','active','latitude','longitude','created_at','update_at'
    ];

    protected $hidden = [
        'category_id'
    ];

    public function scopeSelection($query){
        return $query->select('id','name','address','mobile','category_id','latitude','longitude','logo','active');
     }

    public function getActive(){
        return   $this -> active == 1 ? 'مفعل'  : 'غير مفعل';
    }

    public function getLogoAttribute($value){
        return ($value !== null) ? asset('assets/'.$value): "";
    }

    public function category(){
        return $this->belongsTo(Main_Category::class,'category_id');
    }

}
