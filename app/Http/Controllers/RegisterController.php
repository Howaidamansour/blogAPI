<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends BaseController
{
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=> 'required',
            'email'=> 'required|email',
            'password'=> 'required',
            'c_password'=> 'required|same:password'

            ]);

            if ($validator->fails()){
                return $this->sendError('please validate error',$validator->errors() );
            }

            $inputs = $request->all();
            $inputs['password'] = Hash::make($inputs['password']);
            $user = User::create($inputs);

            $success['token'] = $user->createToken('hudamansour')->accessToken;
            $success['name'] = $user->name;

            return $this->sendResponse($success, 'User registred successfully');
    }


    public function login(Request $request){
        if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password])){
             /** @var \App\Models\User */
            $currentUser = Auth::user();
            $success['token'] = $currentUser->createToken('hudamansour123')->accessToken;
            $success['name']=$currentUser->name;
            return $this->sendResponse($success, 'user logined successfully');
        }
        else{
            return $this->sendError('please check your authorized', ['error', 'Unauthorised']);
        }
      
    }
}
