<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable=[
        'category_id',
        'product_qr_bar_code',
        'sub_category_id',
        'brand_id',
        'name',
        'size',
        'colour',
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
    public function sub_category(){
        return $this->belongsTo(SubCategory::class ,'sub_category_id');
    }
    public function brand(){
        return $this->belongsTo(Brand::class ,'brand_id');
    }
}
