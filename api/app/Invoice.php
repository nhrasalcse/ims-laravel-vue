<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable=[
        'customer_id',
        'total',
        'discount',
        'paid',
        'due',
        'date',
        'payment_method',
        'user_id',

    ];
    public function customer(){
        return $this->belongsTo(Customer::class ,'customer_id');
    }
    public function user(){
    return $this->belongsTo(User::class ,'user_id');
    }
}
