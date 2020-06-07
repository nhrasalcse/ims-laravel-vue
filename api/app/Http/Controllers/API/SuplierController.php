<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Suplier;
use Illuminate\Support\Facades\Auth;

class SuplierController extends Controller
{
    
    public function data(){
       $suplier=Suplier::where('delete_status',1)->paginate(10);
        return$suplier;
    }
    public function store(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'phone'=>'required',
            'image'=>'nullable|image|mimes:jpg,jpeg,png|max:200',
        ]);
       $suplier=new Suplier();
       $suplier->name=$request->name;
       $suplier->phone=$request->phone;
       $suplier->email=$request->email;
       $suplier->address=$request->address;
       $suplier->description=$request->description;
       $suplier->user_id=Auth::user()->id;
        $image=$request->file('image');
        if ($image){
            $imageName='/backend/suplier-image/'.uniqid().$image->getClientOriginalExtension();
            $image->move(public_path() . '/backend/suplier-image', $imageName);
           $suplier->image=$imageName;
        }
       $suplier->save();
        return response()->json(['success']);
    }
    public function edit($id){
       $suplier=Suplier::findOrFail($id);
        return$suplier;
    }
    public function update(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'phone'=>'required',
            'image'=>'nullable|image|mimes:jpg,jpeg,png|max:200',
        ]);
       $suplier=Suplier::findOrFail($request->id);
       $suplier->name=$request->name;
       $suplier->phone=$request->phone;
       $suplier->email=$request->email;
       $suplier->address=$request->address;
       $suplier->description=$request->description;
        $image=$request->file('image');
        if ($image){
            $imageName='/backend/suplier-image/'.uniqid().$image->getClientOriginalExtension();
            if(!empty($image->image)) {
                if (file_exists(public_path( $image->image))) {
                    unlink(public_path( $image->image));
                }
            }
            $image->move(public_path() . '/backend/suplier-image', $imageName);
           $suplier->image=$imageName;
        }
       $suplier->save();
        return response()->json(['success']);
    }
    public function SoftDelete($id){
       $suplier=Suplier::findOrFail($id);
        if ($suplier->delete_status==1){
           $suplier->delete_status=0;
        }else{
           $suplier->delete_status=1;
        }
       $suplier->save();
        return response()->json(['success']);
    }
}
