<?php

namespace App\Http\Controllers\API;

use App\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SubCategory;
use App\Category;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    public function data(){
        $brand=Brand::with(['category','subCategory','user'])->where('delete_status',1)->paginate(10);
        return $brand;
    }
    public function category(){
        $category=Category::where('delete_status',1)->get();
        return $category;
    }
    public function subcategory(){
        $SubCategory=SubCategory::where('delete_status',1)->get();
        return $SubCategory;
    }
    public function store(Request $request){
      $this->validate($request,[
        //   'category_id'=>'required',
        //   'sub_category_id'=>'required',
          'name'=>'required',
          'image'=>'nullable|image|mimes:jpg,jpeg,png|max:200',
      ]);
      $brand=new Brand();
      $brand->category_id=$request->category_id;
      $brand->sub_category_id=$request->sub_category_id;
      $brand->name=$request->name;
      $brand->description=$request->description;
      $brand->user_id=Auth::user()->id;
      $image=$request->file('image');
      if ($image){
          $imageName='/backend/brand-image/'.uniqid().$image->getClientOriginalExtension();
          $image->move(public_path() . '/backend/brand-image', $imageName);
          $brand->image=$imageName;
      }
      $brand->save();
      return response()->json(['success']);
    }
    public function edit($id){
        $brand=Brand::findOrFail($id);
        return $brand;
    }
    public function update(Request $request){
        // return $request;
        $this->validate($request,[
            // 'category_id'=>'required',
            // 'sub_category_id'=>'required',
            'name'=>'required',
            'image'=>'nullable|image|mimes:jpg,jpeg,png|max:200',
        ]);
        $brand=Brand::findOrFail($request->id);

        $brand->category_id=$request->category_id;
        $brand->sub_category_id=$request->sub_category_id;
        $brand->name=$request->name;
        $brand->description=$request->description;
        $image=$request->file('image');
        if ($image){
            $imageName='/backend/brand-image/'.uniqid().$image->getClientOriginalExtension();
            if(!empty($image->image)) {
                if (file_exists(public_path( $image->image))) {
                    unlink(public_path( $image->image));
                }
            }
            $image->move(public_path() . '/backend/brand-image', $imageName);
            $brand->image=$imageName;
        }
        $brand->save();
        return response()->json(['success']);
    }
    public function SoftDelete($id){
        $brand=Brand::findOrFail($id);
        if ($brand->delete_status==1){
            $brand->delete_status=0;
        }else{
            $brand->delete_status=1;
        }
        $brand->save();
        return response()->json(['success']);
    }
    public function Findsubcategory($id){
        $subcate=SubCategory::where('category_id',$id ?? '')->get();
        if(count($subcate)>0){
            return $subcate;
        }else{
            return response()->json(['nodata']);
        }
    }

}
