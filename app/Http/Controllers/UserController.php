<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Http\Controllers\MainController;


class UserController extends MainController
{
    function read(){
        $input = $this->getInput('id');

        $users;

        if($input){
            $users = User::where('id',$input)->get();
        } else {
            $users = User::all();
        }

        return $this->respond(['users' => $users]);
    }

    function read_self(){
        return $this->respond(['users' => auth()->user()]);
    }

    function create(){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|integer'
        ]);

        if($validator->fails()){
            return $this->respond($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'role_id' => $request->get('role')
        ]);

        $user->setRememberToken();

        $token = JWTAuth::fromUser($user);

        return $this->respond(compact('user','token'),200);
    }
}
