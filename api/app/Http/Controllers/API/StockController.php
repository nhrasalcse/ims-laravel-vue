<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Stock;
use App\StockHistoryDaily;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    public function data(){
        $stock=Stock::with([
            'product'=>function($query){ $query->select(['id','name','image']);},
            'suplier'=>function($query){ $query->select(['id','name']);}
            ,])->where('delete_status',1)->paginate(10);
        return $stock;
    }
     public function search(Request $request)
    {
        // return$request->query; 
        
        // $q=$request->input['query'];
        $stock=Stock::all();
        return $stock;
    }
    public function store(Request $request){
        
        
        $this->validate($request,[
            'suplier'=>'required',
            'product_regular_price'=>'required',
            'sell_price'=>'required',
            'retail_price'=>'required',
            'quentity'=>'required',
            // 'stock_level'=>'required',
        ]);
        $oldstock=Stock::findOrFail($request->id);
        $stock=Stock::findOrFail($request->id);
          $stock->user_id=Auth::user()->id;
          $stock->product_qr_code=$request->product_qr_code;
          $stock->suplier=$request->suplier;
          $stock->product_regular_price=$request->product_regular_price;
          $stock->sell_price=$request->sell_price;
          $stock->retail_price=$request->retail_price;
          $stock->stock_in=($oldstock->stock_in+$request->quentity);
          $stock->stock_level=$request->stock_level ?? $stock->stock_level;
          if($stock->save()){
              $oldStockhistry=StockHistoryDaily::where('stock_id',$oldstock->id)->latest()->first();
              if($oldStockhistry->date==date('Y-m-d')){
                $oldStockhistry->user_id=Auth::user()->id;
                $oldStockhistry->product_qr_code=$request->product_qr_code;
                $oldStockhistry->suplier=$request->suplier;
                $oldStockhistry->product_regular_price=$request->product_regular_price;
                $oldStockhistry->sell_price=$request->sell_price;
                $oldStockhistry->retail_price=$request->retail_price;
                $oldStockhistry->stock_in=$oldStockhistry->stock_in+$request->quentity;
                $oldStockhistry->stock_level=$request->stock_level ?? $stock->stock_level;
                $oldStockhistry->save();
              }else{
                $stock_history=new StockHistoryDaily();
                $stock_history->product_id= $stock->product_id;
                $stock_history->stock_id=$stock->id;
                $stock_history->user_id=Auth::user()->id;
                $stock_history->product_qr_code=$request->product_qr_code;
                $stock_history->suplier=$request->suplier;
                $stock_history->product_regular_price=$request->product_regular_price;
                $stock_history->sell_price=$request->sell_price;
                $stock_history->retail_price=$request->retail_price;
                $stock_history->stock_in= $request->quentity;
                $stock_history->stock_level=$request->stock_level ?? $stock->stock_level;
                $stock_history->date=date('Y-m-d');
                $stock_history->save();
            }
              
              return response()->json(['success']);
          }
      }
    public function edit($id){
        $stock=Stock::findOrFail($id);
        return $stock;
    }
    public function update(Request $request){
        // return $request;
        $this->validate($request,[
            'name'=>'required',
            'phone'=>'required',
            'gender'=>'required',
            'image'=>'nullable|image|mimes:jpg,jpeg,png|max:200',
        ]);
        $stock=Stock::findOrFail($request->id);
        $stock->name=$request->name;
        $stock->phone=$request->phone;
        $stock->email=$request->email;
        $stock->gender=$request->gender;
        $stock->address=$request->address;
        $stock->details=$request->details;
        $image=$request->file('image');
        $stock->save();
        return response()->json(['success']);
    }
    public function SoftDelete($id){
        $stock=Stock::findOrFail($id);
        if ($stock->delete_status==1){
            $stock->delete_status=0;
        }else{
            $stock->delete_status=1;
        }
        $stock->save();
        return response()->json(['success']);
    }
}
