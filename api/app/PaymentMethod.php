<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
  protected $fillable=[

   'customer_id',
   'invoice_id',
   'method',
   'ammount',
   'card_number',
   'card_name',
   'bank_name',
   'branch',
   'check_number',
   'account_holder',
   'mobile_number',
   'tax_id',
   'operator',
   'user_id',
  ];
  public function invoice(){
    return $this->belongsTo(Invoice::class ,'invoice_id');
}
  public function customer(){
    return $this->belongsTo(Customer::class ,'customer_id');
}
public function user(){
 return $this->belongsTo(User::class ,'user_id');
 }
}
