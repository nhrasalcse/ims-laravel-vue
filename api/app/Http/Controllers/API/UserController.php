<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;
use App\RoleUserID;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function data(){
      $user=User::where('delete_status',1)->where('id','!=', Auth::user()->id)->paginate(10);
        return $user; 
    }
    public function role(){
      return $role=Role::all();
    }
    public function store(Request $request){
      
      $this->validate($request,[
            'name'=>'required',
            'phone'=>'required|unique:users',
            'address'=>'required|min:6',
            'email'=>'required|email|unique:users',
            'password' => 'required|min:6',
            'image'=>'nullable|image|mimes:jpg,jpeg,png|max:200',
        ]);
        return $request;
      $user=new User();
      $user->name=$request->name;
      $user->phone=$request->phone;
      $user->email=$request->email;
      $user->address=$request->address;
      $user->creator_id=Auth::user()->id;
      $user->password=Hash::make($request->password);
        $image=$request->file('image');
        if ($image){
            $imageName='/backend/user-image/'.uniqid().$image->getClientOriginalExtension();
            $image->move(public_path() . '/backend/user-image', $imageName);
          $user->image=$imageName;
        }
     if( $user->save()){
       $role=new RoleUserID ();
       $role->user_id=$user->id;
       $role->role_id=$request->role;
       $role->save();
       return response()->json(['success']);
     }
    }
    public function edit($id){
      $user=User::findOrFail($id);
      $role=RoleUserID::with(['role','user'])->where('user_id',$user->id)->first();
      // return response()->json($user,$role);
      return [$user,$role];
    }
    public function update(Request $request){
      // return $request;
        $this->validate($request,[
            'name'=>'required',
            'phone'=>'required',
            'email'=>'required',
            'image'=>'nullable|image|mimes:jpg,jpeg,png|max:200',
        ]);
      $user=User::findOrFail($request->id);
      $user->name=$request->name;
      $user->phone=$request->phone;
      $user->email=$request->email;
      $user->address=$request->address;
      // $user->details=$request->details;
      $user->password=Hash::make($request->password);
        $image=$request->file('image');
        if ($image){
            $imageName='/backend/user-image/'.uniqid().$image->getClientOriginalExtension();
            if(!empty($image->image)) {
                if (file_exists(public_path( $image->image))) {
                    unlink(public_path( $image->image));
                }
            }
            $image->move(public_path() . '/backend/user-image', $imageName);
          $user->image=$imageName;
        }
        if( $user->save()){
          $role=RoleUserID::where('user_id',$request->id)->first();
          // $role->user_id=$user->id;
          $role->role_id=$request->role;
          $role->save();
          return response()->json(['success']);
        }
    }
    public function SoftDelete($id){
      $user=User::findOrFail($id);
        if ($user->delete_status==1){
          $user->delete_status=0;
          $user->status=0;
        }else{
          $user->delete_status=1;
          $user->status=1;
        }
      $user->save();
      return response()->json(['success']);
    }
}
