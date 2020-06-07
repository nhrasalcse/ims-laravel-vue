<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
   public function data(){
       $category=Category::where('delete_status',1)->paginate(10);
       return $category;
   }
   public function store(Request $request){
    //    return $request;
       $this->validate($request,[
           'name'=>'required',
        //    'description'=>'required',
           'image'=>'nullable|image|mimes:jpg,jpeg,png|max:200',
       ]);
       $category=new Category();
       $category->name=$request->name;
       $category->description=$request->description;
       $category->user_id=Auth::user()->id;
       $image=$request->file('image');
       if ($image){
           $imageName='/backend/category-image/'.uniqid().$image->getClientOriginalExtension();
           $image->move(public_path() . '/backend/category-image', $imageName);
           $category->image=$imageName;
       }
       $category->save();
       return response()->json(['success']);
   }
   public function edit($id){
       $category=Category::findOrFail($id);
       return $category;
   }
    public function update(Request $request){
        $this->validate($request,[

            'name'=>'required',
            // 'description'=>'required',
            'image'=>'nullable|image|mimes:jpg,jpeg,png|max:200',
        ]);
        $category=Category::findOrFail($request->id);
        $category->name=$request->name;
        $category->description=$request->description;
        $image=$request->file('image');
        if ($image){
            $imageName='/backend/category-image/'.uniqid().$image->getClientOriginalExtension();
            if(!empty($image->image)) {
                if (file_exists(public_path( $image->image))) {
                    unlink(public_path( $image->image));
                }
            }
            $image->move(public_path() . '/backend/category-image', $imageName);
            $category->image=$imageName;
        }
        $category->save();
        return response()->json(['success']);
    }
    public function SoftDelete($id){
    $category=Category::findOrFail($id);
    if ($category->delete_status==1){
        $category->delete_status=0;
    }else{
        $category->delete_status=1;
    }
    $category->save();
    return response()->json(['success']);
}
}
