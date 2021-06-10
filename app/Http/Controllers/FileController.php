<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\MainController;
use App\Tables\FileTable;
use App\Http\Validators\FileValidator;

class FileController extends MainController{

    public function __construct(){
        $this->table = new FileTable();
        $this->validator = new FileValidator();
        parent::__construct();
    }

    protected function handleCreate(){

        if($this->request->request->hasFile('files')){
            error_log("HASFILE");
            foreach($this->request->request->file('files') as $file){
                error_log("hello");
                $this->create($file);
            }
        }

        /*
        foreach($body as $ele){
            //run the create function for each object
            $created = $this->create($ele);
            //if one of them throws and error return;
            if(Helper::isResponse($created)){
                return $created;
            }
            //push the created ele to the results
            array_push($data,$created);
        }
        */

        return $this->afterCreate([]);
    }

    protected function create($create = null){
        //validate the data
        /*
        $validate = $this->validateCreate($create);

        if($validate !== true){
            return $validate;
        }
        */

        $created = $this->createOne($create);

        return $created;
    }

    protected function createOne($create = null){
        // $this->table->model::create($create);
        error_log("create $create");
        $path = $create->storeAs('uploads',$create->getClientOriginalName(),'public');

        return $create;
    }
}
