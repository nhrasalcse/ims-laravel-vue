<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceHistory extends Model
{
    protected $fillable=[
        'invoice_id',
        'product_id',
        'product_price',
        'product_qty',
        'sub_total',
        'discount',
        'date',
        'delete_status',
        'user_id',
    ];

    public function invocice(){
        return $this->belongsTo(Invoice::class ,'invoice_id');
    }
    public function product(){
        return $this->belongsTo(Product::class ,'product_id');
    }
    public function user(){
    return $this->belongsTo(User::class ,'user_id');
    }
}
