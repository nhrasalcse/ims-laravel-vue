<?php

namespace App\Http\Controllers\API;

use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function data(){
        $customer=Customer::where('delete_status',1)->paginate(10);
        return $customer;
    }
     public function search(Request $request)
    {
        // return$request->query; 
        
        // $q=$request->input['query'];
        $customer=Customer::all();
        return $customer;
    }
    public function store(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'phone'=>'required',
            'gender'=>'required',
            'image'=>'nullable|image|mimes:jpg,jpeg,png|max:200',
        ]);
        $customer=new Customer();
        $customer->name=$request->name;
        $customer->phone=$request->phone;
        $customer->email=$request->email;
        $customer->gender=$request->gender;
        $customer->address=$request->address;
        $customer->details=$request->details;
        $image=$request->file('image');
        if ($image){
            $imageName='/backend/customer-image/'.uniqid().$image->getClientOriginalExtension();
            $image->move(public_path() . '/backend/customer-image', $imageName);
            $customer->image=$imageName;
        }
        $customer->save();
        
        return $customer;
        return response()->json(['success']);
    }
    public function edit($id){
        $customer=Customer::findOrFail($id);
        return $customer;
    }
    public function update(Request $request){
        // return $request;
        $this->validate($request,[
            'name'=>'required',
            'phone'=>'required',
            'gender'=>'required',
            'image'=>'nullable|image|mimes:jpg,jpeg,png|max:200',
        ]);
        $customer=Customer::findOrFail($request->id);
        $customer->name=$request->name;
        $customer->phone=$request->phone;
        $customer->email=$request->email;
        $customer->gender=$request->gender;
        $customer->address=$request->address;
        $customer->details=$request->details;
        $image=$request->file('image');
        if ($image){
            $imageName='/backend/customer-image/'.uniqid().$image->getClientOriginalExtension();
            if(!empty($image->image)) {
                if (file_exists(public_path( $image->image))) {
                    unlink(public_path( $image->image));
                }
            }
            $image->move(public_path() . '/backend/customer-image', $imageName);
            $customer->image=$imageName;
        }
        $customer->save();
        return response()->json(['success']);
    }
    public function SoftDelete($id){
        $customer=Customer::findOrFail($id);
        if ($customer->delete_status==1){
            $customer->delete_status=0;
        }else{
            $customer->delete_status=1;
        }
        $customer->save();
        return response()->json(['success']);
    }
}
