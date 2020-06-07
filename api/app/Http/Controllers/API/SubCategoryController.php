<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SubCategory;
use App\Category;
use Illuminate\Support\Facades\Auth;

class SubCategoryController extends Controller
{
    public function data(){
        $sub=SubCategory::with('category')->where('delete_status',1)->paginate(10);
        return $sub;
    }
    public function category(){
        $SubCategory=Category::where('delete_status',1)->get();
        return $SubCategory;
    }
    public function store(Request $request){
        $this->validate($request,[
 
            'category_id'=>'required',
            'name'=>'required',
            'description'=>'required',
            'image'=>'nullable|image|mimes:jpg,jpeg,png|max:200',
        ]);
        $SubCategory=new SubCategory();
        $SubCategory->name=$request->name;
        $SubCategory->category_id=$request->category_id;
        $SubCategory->description=$request->description;
        $SubCategory->user_id=Auth::user()->id;
        $image=$request->file('image');
        if ($image){
            $imageName='/backend/subcategory-image/'.uniqid().$image->getClientOriginalExtension();
            $image->move(public_path() . '/backend/subcategory-image', $imageName);
            $SubCategory->image=$imageName;
        }
        $SubCategory->save();
        return response()->json(['success']);
    }
    public function edit($id){
        $SubCategory=SubCategory::findOrFail($id);
        return $SubCategory;
    }
     public function update(Request $request){
        //  return $request;
         $this->validate($request,[
 
             'name'=>'required',
             'category_id'=>'required',
             'description'=>'required',
             'image'=>'nullable|image|mimes:jpg,jpeg,png|max:200',
         ]);
         $SubCategory=SubCategory::findOrFail($request->id);
         $SubCategory->name=$request->name;
         $SubCategory->category_id=$request->category_id;
         $SubCategory->description=$request->description;
         $image=$request->file('image');
         if ($image){
             $imageName='/backend/subcategory-image/'.uniqid().$image->getClientOriginalExtension();
             if(!empty($image->image)) {
                 if (file_exists(public_path( $image->image))) {
                     unlink(public_path( $image->image));
                 }
             }
             $image->move(public_path() . '/backend/subcategory-image', $imageName);
             $SubCategory->image=$imageName;
         }
         $SubCategory->save();
         return response()->json(['success']);
     }
     public function SoftDelete($id){
     $SubCategory=SubCategory::findOrFail($id);
     if ($SubCategory->delete_status==1){
         $SubCategory->delete_status=0;
     }else{
         $SubCategory->delete_status=1;
     }
     $SubCategory->save();
     return response()->json(['success']);
 }
}
