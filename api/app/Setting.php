<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable=[
      'business',
      'name',
      'phone',
      'email',
      'address',
      'company_details',
      'logo',
      'currency',
    ];
}
