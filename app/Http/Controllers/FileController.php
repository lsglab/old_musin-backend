<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\MainController;
use App\Tables\FileTable;
use App\Http\Validators\FileValidator;
use Illuminate\Support\Facades\Storage;
use App\Helper;

class FileController extends MainController{

    public function __construct(){
        $this->table = new FileTable();
        $this->validator = new FileValidator();
        parent::__construct();
    }

    protected function handleCreate(){
        if($this->request->request->hasFile('file')){
            $data = $this->create();
            return Helper::isResponse($data) ? $data : $this->afterCreate([$data]);
        }

        return $this->respond(['message' => 'No file attached'],400);
    }

    protected function deleteOne($entry){
        parent::deleteOne($entry);
        Storage::delete($entry->path);
    }

    protected function createOne($create = null){
        $public = 'public';
        if($create['public'] === false)  $public = 'private';

        $path = $create['file']->storeAs('uploads',$create['name'],$public);

        return parent::createOne([
            'name' => $create['name'],
            'description' => $create['description'],
            'size' => $create['size'],
            'type' => $create['type'],
            'public' => $create['public'],
            'path' => $path
        ]);
    }
}
