<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Setting;

class SettingsController extends Controller
{
    public function data(){
        $settings=Setting::where('delete_status',1)->get();
        return $settings;
    }
    public function store(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'phone'=>'required',
        ]);
        $settings=new Setting();
        $settings->business=$request->business;
        $settings->name=$request->name;
        $settings->phone=$request->phone;
        $settings->email=$request->email;
        $settings->address=$request->address;
        $settings->company_details=$request->company_details;
        $settings->currency=$request->currency;
        $image=$request->file('logo');
        if ($image){
            $imageName='/backend/setting-image/'.uniqid().$image->getClientOriginalExtension();
            $image->move(public_path() . '/backend/setting-image', $imageName);
            $settings->logo=$imageName;
        }
        $settings->save();
        return response()->json(['success']);
    }
    public function edit($id){
        $settings=Setting::faidOrFail($id);
        return $settings;
    }
    public function update(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'phone'=>'required',
        ]);
        $settings->business=$request->business;
        $settings->name=$request->name;
        $settings->phone=$request->phone;
        $settings->email=$request->email;
        $settings->address=$request->address;
        $settings->company_details=$request->company_details;
        $settings->currency=$request->currency;
        $image=$request->file('logo');
        if ($image){
            $imageName='/backend/setting-image/'.uniqid().$image->getClientOriginalExtension();
            if(!empty($image->logo)) {
                if (file_exists(public_path( $image->logo))) {
                    unlink(public_path( $image->logo));
                }
            }
            $image->move(public_path() . '/backend/setting-image', $imageName);
            $settings->logo=$imageName;
        }
        $settings->save();
        return response()->json(['success']);
    }
    public function Delete($id){
        $settings=Setting::findOrFail($id);
        $settings->delete();
        return response()->json(['success']);
    }
}
