<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

use Validator;

class RegisterController extends BaseController
{
    /**
     * Register api function
     */

    public function register(Request $request)

    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required',     
            'confirm_password' => 'required|same:password',

        ]);


        if($validator->fails()){

            return $this->sendError('Validation Error.', $validator->errors());       

        }

   
        $input = $request->all();
        $input['role'] = strtoupper($input['role']);
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('ApiToken')->accessToken;
        $success['name'] =  $user->name;
        $success['role'] =  $user->role;

        return $this->sendResponse($success, 'User registered successfully.');

    }

   

    /**
     * Login api
     */

    public function login(Request $request)

    {

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 

            $user = Auth::user(); 
            $success['token'] =  $user->createToken('ApiToken')->accessToken;
            $success['name'] =  $user->name;
            $success['role'] =  $user->role;
   

            return $this->sendResponse($success, 'User logged in successfully.');

        } 

        else{ 

            return $this->sendError('Unauthorised user.', ['error'=>'Unauthorised']);

        } 

    }
}
