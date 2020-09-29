<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Translatable;

    protected $with = ['translations'];

    protected $fillable =['parent_id','slug','is_active'];

    protected $translatedAttributes = ['name'];

    protected $hidden = ['translations'];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function scopeParent($query){
        return $query->whereNull('parent_id');
    }

    public function scopeChild($query){
        return $query->whereNotNull('parent_id');
    }

    public function getActive(){
        return   $this->is_active == 1 ? 'مفعل'  : 'غير مفعل';
    }

    public function _parent(){
        return $this->belongsTo(self::class,'parent_id');
    }

    public function _childs(){
        return $this->hasMany(self::class,'parent_id');
    }
    
}
