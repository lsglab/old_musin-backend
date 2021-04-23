<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public Request $request;
    public $actions = ['read','read-self','edit','edit-self','delete','delete-self','create'];

    public function handle(Request $request){
        $this->request = $request;

        switch($this->request->permission){
            case 'read':
                return $this->read();
                break;
            case 'read-self':
                return $this->read_self();
                break;
            case 'edit':
                return $this->edit();
                break;
            case 'edit-self':
                return $this->edit_self();
                break;
            case 'delete':
                return $this->delete();
                break;
            case 'delete-self':
                return $this->delete_self();
                break;
            case 'create':
                return $this->create();
                break;
            default:
                return $this->respond(['message' => 'action_does_not_exist'],400);
                break;
        }
    }

    function respond($array,$status = 200){
        return response()->json($array,$status);
    }

    function getInput($input){
        $prop = $this->request->input($input);

        if(gettype($prop) === 'NULL'){
            return false;
        } else {
            return $prop;
        }
    }
}
