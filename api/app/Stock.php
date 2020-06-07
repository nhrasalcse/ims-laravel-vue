<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
   protected $fillable=[

    'product_id',
    'product_qr_code',
    'suplier',
    'product_regular_price',
    'sell_price',
    'retail_price',
    'quentity',
    'stock_level',
    'stock_in',
    'stock_out',
    'user_id',
    'date',
   ];

        public function product(){
            return $this->belongsTo(Product::class ,'product_id');
        }
        public function user(){
        return $this->belongsTo(User::class ,'user_id');
        }
        public function suplier(){
        return $this->belongsTo(Suplier::class ,'suplier');
        }
}
