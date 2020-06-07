<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function data(){
        $user=User::findOrFail(Auth::user()->id);
          return $user;
      }
      public function update(Request $request){
          $this->validate($request,[
              'name'=>'required',
              'phone'=>'required',
          ]);
        $user=User::findOrFail(Auth::user()->id);
        $user->name=$request->name;
        $user->phone=$request->phone;
        $user->email=$request->email;
        $user->address=$request->address;
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
        $user->save();
          return response()->json(['success']);
      }
      public function SoftDelete($id){
        $user=User::findOrFail($id);
          if ($User->delete_status==1){
            $user->delete_status=0;
            $user->status=0;
          }else{
            $user->delete_status=1;
            $user->status=1;
          }
        $user->save();
          return response()->json(['success']);
      }
      public function ProfilePasswordUpdate(Request $request){
        $this->validate($request, [
            'oldPassword' => 'required',
            'password' => 'required|confirmed'
        ]);
        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->oldPassword, $hashedPassword))
        {

            if (!Hash::check($request->password,$hashedPassword))
            {
                $user = User::find(Auth::user()->id);
                $user->password = Hash::make($request->password);
                $user->save();
                return response()->json(['success']);
            }else{
                return response()->json(['newnotmatch']);
            }
        }else{
            return response()->json(['oldnotmatch']);
        }

    }
}
