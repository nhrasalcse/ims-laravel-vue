<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Brand;
use App\Product;
use App\Category;
use App\SubCategory;
use App\Stock;
use App\StockHistoryDaily;
use App\Suplier;


class ProductController extends Controller
{
    public function data(){
       $product=Product::with(['category','sub_category','brand','user'])->where('delete_status',1)->orderBy('id','desc')->paginate(10);
        return$product;
    }
    public function suplier(){
        $suplier=Suplier::where('delete_status',1)->get();
        return $suplier;
    }
     public function Branddata()
    {
        $brand=Brand::where('delete_status',1)->get();
        return $brand;
    }
    public function store(Request $request){
      $this->validate($request,[
          'category_id'=>'required',
          'sub_category_id'=>'required',
          'brand_id'=>'required',
          'name'=>'required',
          'colour'=>'required',
          'size'=>'required',
          'suplier'=>'required',
          'product_regular_price'=>'required',
          'sell_price'=>'required',
          'retail_price'=>'required',
          'quentity'=>'required',
          'stock_level'=>'required',
          'image'=>'nullable|image|mimes:jpg,jpeg,png|max:200',
      ]);
     $product=new Product();
     $product->category_id=$request->category_id;
     $product->sub_category_id=$request->sub_category_id;
     $product->brand_id=$request->brand_id;
     $product->name=$request->name;
     $product->description=$request->description;
     $product->size=$request->size;
     $product->colour=$request->colour;
     $product->user_id=Auth::user()->id;
      $image=$request->file('image');
      if ($image){
          $imageName='/backend/product-image/'.uniqid().$image->getClientOriginalExtension();
          $image->move(public_path() . '/backend/product-image', $imageName);
         $product->image=$imageName;
      }
      if($product->save()){
        $stock=new Stock();
        $stock->product_id=$product->id;
        $stock->user_id=Auth::user()->id;
        $stock->product_qr_code=$request->product_qr_code;
        $stock->suplier=$request->suplier;
        $stock->product_regular_price=$request->product_regular_price;
        $stock->sell_price=$request->sell_price;
        $stock->retail_price=$request->retail_price;
        $stock->stock_in=$request->quentity;
        $stock->stock_out=0;
        $stock->stock_level=$request->stock_level;
        if($stock->save()){
            $stock_history=new StockHistoryDaily();
            $stock_history->product_id=$product->id;
            $stock_history->stock_id=$stock->id;
            $stock_history->user_id=Auth::user()->id;
            $stock_history->product_qr_code=$request->product_qr_code;
            $stock_history->suplier=$request->suplier;
            $stock_history->product_regular_price=$request->product_regular_price;
            $stock_history->sell_price=$request->sell_price;
            $stock_history->retail_price=$request->retail_price;
            $stock_history->stock_in=$request->quentity;
            $stock_history->stock_out=0;
            $stock_history->stock_level=$request->stock_level;
            $stock_history->save();
            return response()->json(['success']);
        }
    }

    }
    public function edit($id){
       $product=Product::findOrFail($id);
        return$product;
    }
    public function update(Request $request){
        // return $request;
        $this->validate($request,[
            'category_id'=>'required',
            'sub_category_id'=>'required',
            'name'=>'required',
            'image'=>'nullable|image|mimes:jpg,jpeg,png|max:200',
        ]);
       $product=Product::findOrFail($request->id);
       $product->category_id=$request->category_id;
       $product->sub_category_id=$request->sub_category_id;
       $product->brand_id=$request->brand_id;
       $product->name=$request->name;
       $product->description=$request->description;
       $product->size=$request->size;
       $product->colour=$request->colour;
       $product->user_id=Auth::user()->id;
        $image=$request->file('image');
        if ($image){
            $imageName='/backend/product-image/'.uniqid().$image->getClientOriginalExtension();
            if(!empty($image->image)) {
                if (file_exists(public_path( $image->image))) {
                    unlink(public_path( $image->image));
                }
            }
            $image->move(public_path() . '/backend/product-image', $imageName);
           $product->image=$imageName;
        }
        
     $product->save();
     return response()->json(['success']);
    }
    public function SoftDelete($id){
       $product=Product::findOrFail($id);
        if ($product->delete_status==1){
           $product->delete_status=0;
        }else{
           $product->delete_status=1;
        }
       $product->save();
        return response()->json(['success']);
    }
    public function FindBrand($id){
        $subcate=Brand::where('category_id',$id ?? '')->get();
        if(count($subcate)>0){
            return $subcate;
        }else{
            return response()->json(['nodata']);
        }
    }
}
