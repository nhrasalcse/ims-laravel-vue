<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
   protected $fillable=[
    'category_id',
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
}
