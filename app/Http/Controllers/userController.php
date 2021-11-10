<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\userregistration;
use Validator;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
    //
    

    function addUser(Request $req)
    {
        $rules = array(
            "name"=>"required|min:6|max:20",
            "email"=>"required|unique:userregistrations,email",
            "phone"=>"required|unique:userregistrations,phone|digits:10",
            "password"=>"required",
            "address"=>"required"
        );

        $validator = Validator::make($req->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->errors(),401);
        }else{
            $user = new userregistration;
            $user->name=$req->name;
            $user->email=$req->email;
            $user->phone=$req->phone;
            $user->password=Hash::make($req->password);
            $user->address=$req->address;
            $result = $user->save();
            if($result)
            {
                return ['result'=>$user->name.', Your Data has been saved successfully!!'];
            }else{
                return ['result'=>'Operation failed... Please retry!!'];
            }
        }
        
    }

    function loginUser($email){
        return response()->json(userregistration::where('email',$email)->first());

    }

    function updateUser(Request $req){
        $rules = array(
            "name"=>"required|min:6|max:20",
            "password"=>"required",
            "address"=>"required"
        );

        $validator = Validator::make($req->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->errors(),401);
        }else{
        $update = userregistration::where('email',$req->email)->first();
            $update->name=$req->name;
            $update->password=Hash::make($req->password);
            $update->address=$req->address;
            $result = $update->save();
            if($result)
            {
                return ['result'=>$update->name.', Your Data has been updated successfully!!'];
            }else{
                return ['result'=>'Operation failed... Please retry!!'];
            }
        }
    }
}
