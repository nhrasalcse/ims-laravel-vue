<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Invoice;
use App\Product;
use App\Stock;
use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function data(){
        $invoice=Invoice::with(['customer','user'])->where('delete_status',1)->get();
        return $invoice;
    }
    public function Customers(){
        $customer=Customer::where('delete_status',1)->get();
        return $customer;
    }
    public function Stock(){
        $stock=Stock::with([
            'product'=>function($query){ $query->select(['id','name','image']);}
            ,])->where('delete_status',1)->get();
        return $stock;
    }
    public function FindProduct($id){
        $stock=Stock::with([
            'product'=>function($query){ $query->select(['id','name','image']);}
            ,])->where('delete_status',1)->where('product_id',$id)->first();
        return $stock;
    }
    public function store(Request $request){
        return $request;
        $this->validate($request,[
            'customer_id'=>'required',
            // 'total'=>'required',
            // 'paid'=>'required',
            // 'payment_method'=>'required',
        ]);
        $invoice=new Invoice();
        $invoice->customer_id=$request->customer_id;
        $invoice->total=$request->total;
        $invoice->discount=$request->discount;
        $invoice->paid=$request->paid;
        $invoice->due=$request->due;
        $invoice->payment_method=$request->payment_method;
        $invoice->date=date('d-m-Y');
        $invoice->user_id=Auth::user()->id;
        $invoice->save();
        return response()->json(['success']);
    }
    public function edit($id){
        $invoice=Invoice::with(['customer','user'])->faidOrFail($id);
        return $invoice;
    }
    public function update(Request $request){
        $this->validate($request,[
            'customer_id'=>'required',
            'total'=>'required',
            'paid'=>'required',
            'payment_method'=>'required',
        ]);
        $invoice=Invoice::findOrFail($request->id);
        $invoice->customer_id=$request->customer_id;
        $invoice->total=$request->total;
        $invoice->discount=$request->discount;
        $invoice->paid=$request->paid;
        $invoice->due=$request->due;
        $invoice->payment_method=$request->payment_method;
        $invoice->save();
        return response()->json(['success']);
    }
    public function SoftDelete($id){
        $invoice=Invoice::findOrFail($id);
        if ($invoice->delete_status==1){
            $invoice->delete_status=0;
        }else{
            $invoice->delete_status=1;
        }
        $invoice->save();
        return response()->json(['success']);
    }
}
