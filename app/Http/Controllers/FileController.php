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

    private function getDefaultBuilder(){
        $role = auth()->user()->role()->first();

        if(strtolower($role->name) === 'public'){
            return $this->table->model::where('public',true);
        }

        return null;
    }

    public function read($query = null){
        $builder = $this->getDefaultBuilder();

        return $this->builder->get($builder,$query);
    }

    public function readSelf($query = null){
        $user = auth()->user();

        $builder = $this->getDefaultBuilder();

        if($builder === null){
            $builder = $this->table->model::where('creator_id',$user->id);
        } else {
            $builder = $builder->where('creator_id',$user->id);
        }

        return $this->builder->get($builder,$query);
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
        Storage::disk($entry->disk)->delete($entry->path);
    }

    protected function createOne($create = null){
        $disk = 'public';
        if($create['public'] === false)  $disk = 'private';

        $url = $create['file']->storeAs('uploads',$create['name'],$disk);

        $name = $create['name'];

        if(!$create['public']){
            $url = "uploads/private/$name";
        }

        $path = "uploads/$name";
        $location = "app/$disk/$path";

        return parent::createOne([
            'name' => $create['name'],
            'description' => $create['description'],
            'size' => $create['size'],
            'type' => $create['type'],
            'path' => $path,
            'disk' => $disk,
            'public' => $create['public'],
            'location' => $location,
            'url' => $url
        ]);
    }

    private function getFilePath($fileName){
        $data = $this->read(['name' => $fileName]);

        if($data->count() > 0){
            $file = $data->first();
            $filepath = storage_path($file->location);
            return $filepath;
        }

        return false;
    }

    public function getFile($fileName){
        $file = $this->getFilePath($fileName);

        if($file !== false) return response()->file($file);
        abort(404);
    }

    public function downloadFile($fileName){
        $file = $this->getFilePath($fileName);

        if($file !== false) return response()->download($file);
        abort(404);
    }
}
