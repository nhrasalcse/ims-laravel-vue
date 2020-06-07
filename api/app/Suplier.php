<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suplier extends Model
{
    protected $fillable=[
                'name',
                'phone',
                'email',
                'address',
                'description',
                'image',
                'user_id',
    ];

   public function user(){
    return $this->belongsTo(User::class ,'user_id');
    }
}
