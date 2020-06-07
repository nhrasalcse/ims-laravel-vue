<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable=[
            'category_id',
            'sub_category_id',
            'name',
            'description',
            'image',
            'user_id',
    ];

    public function category(){
        return $this->belongsTo(Category::class ,'category_id');
    }
    public function user(){
     return $this->belongsTo(User::class ,'user_id');
     }
    public function subCategory(){
        return $this->belongsTo(SubCategory::class ,'sub_category_id');
    }

}
