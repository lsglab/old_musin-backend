<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DatabaseController extends Controller
{

    function handle(Request $request){
        switch($request->permission){
            case 'read':
                return $this->read($request);
                break;
            case 'read-self':
                return $this->read_self($request);
                break;
            case 'edit':
                return $this->edit($request);
                break;
            case 'edit-self':
                return $this->edit_self($request);
                break;
            case 'delete':
                return $this->delete($request);
                break;
            case 'delete-self':
                return $this->delete_self($request);
                break;
            case 'create':
                return $this->create($request);
                break;
        }
    }

    function read(Request $request){
        return "nice";
    }

    function read_self(Request $request){

    }

    function edit(Request $request){

    }

    function edit_self(Request $request){

    }

    function delete(Request $request){

    }

    function delete_self(Request $request){

    }

    function create(Request $request){

    }

    function respond($array){
        return response()->json($array);
    }
}
