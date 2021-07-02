<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\MainController;
use App\Tables\FileTable;
use App\Models\File;
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
            $file = $this->request->request->file('file');

            $this->request->request['size'] = $file->getSize();

            $data = $this->create();
            return Helper::isResponse($data) ? $data : $this->afterCreate([$data]);
        }

        return $this->respond(['message' => 'No file attached'],400);
    }

    protected function deleteOne($entry){
        parent::deleteOne($entry);
        Storage::disk($entry->disk)->delete($entry->path);
    }

    protected function getFileInformation(string $filePath) : array{
        $basePath = storage_path();
        $filePath = "{$basePath}/{$filePath}";
        $type = mime_content_type($filePath);
        error_log("type $type");
        $size = filesize($filePath);

        return [
            'type' => $type,
            'size' => $size
        ];
    }

    protected function getFilePathInformation(bool $public,string $name) : array{
        $disk = 'public';
        if($public === false)  $disk = 'private';

        $url = "uploads/$name";

        if(!$public){
            $url = "uploads/private/$name";
        }

        $path = "uploads/$name";
        $location = "app/$disk/$path";

        return [
            'disk' => $disk,
            'url' => $url,
            'path' => $path,
            'location' => $location,
        ];
    }

    protected function createOne($create){
        $file = $this->request->request->file('file');
        $path = $this->getFilePathInformation($create['public'],$create['name']);

        $file->storeAs('uploads',$create['name'],$path['disk']);

        $info = $this->getFileInformation($path['location']);

        return parent::createOne([
            'name' => $create['name'],
            'description' => $create['description'],
            'public' => $create['public'],
            'size' => $info['size'],
            'type' => $info['type'],
            'path' => $path['path'],
            'disk' => $path['disk'],
            'location' => $path['location'],
            'url' => $path['url']
        ]);
    }

    protected function editOne($entry,$editData){
        $original = $entry->replicate();
        $entry = parent::editOne($entry,$editData);

        $path = $this->getFilePathInformation($entry->public,$entry->name);
        $info = $this->getFileInformation($original->path);

        $entry->disk = $path['disk'];
        $entry->url = $path['url'];
        $entry->path = $path['path'];
        $entry->location = $path['location'];
        $entry->size = $info['size'];
        $entry->type = $info['type'];
        $entry->save();

        if($this->request->request->hasFile('file')){
            Storage::disk($original->disk)->delete($original->path);
            $this->request->request->file('file')->storeAs('uploads',$entry->name,$entry->disk);
        } else {
            if($entry->disk !== $original->disk){
                $file = Storage::disk($original->disk)->get($original->path);
                Storage::disk($entry->disk)->put($entry->path,$file);
                Storage::disk($original->disk)->delete($original->path);
            }
            else if($entry->name !== $original->name){
                Storage::disk($entry->disk)->move($original->path,$entry->path);
            }
        }

        return $entry;
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
