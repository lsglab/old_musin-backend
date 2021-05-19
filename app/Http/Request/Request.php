<?php

namespace App\Http\Request;
use Illuminate\Http\Request as IlluminateRequest;

class Request{

    public IlluminateRequest $request;

    public function __construct(IlluminateRequest $request = null){
        if($request === null){
            $this->request = request();
        }
    }

    public function getRequestBody(){
        return json_decode($this->request->getContent(),true);
    }

    public function getInput($input){
        $prop = $this->request->input($input);
        if($prop === null){
            return false;
        } else {
            return $prop;
        }
    }

    public function getQuery(){
        $query = $this->request->query();

        if(count($query) > 0){
            return $query;
        } else {
            return false;
        }
    }

    public function getAction(){
        switch($this->request->method()){
            case 'POST':
                return 'create';
                break;
            case 'GET':
                return 'read';
                break;
            case 'PUT':
                return 'edit';
                break;
            case 'DELETE':
                return 'delete';
                break;
        }
    }
}
