<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\MainController;
use Illuminate\Support\Facades\Storage;
use App\Tables\SiteTable;
use App\Helper;
use App\Http\Validators\SiteValidator;

class SiteController extends MainController{
    public function __construct(){
        $this->table = new SiteTable();
        $this->validator = new SiteValidator();
        parent::__construct();
    }

    protected function handleCreate(){
        $body = $this->request->getRequestBody();
        if(array_key_exists('0',$body)){
            return $this->respond(['message' => 'Invalid data. Expected object'],400);
        }

        $data = $this->create();

        return Helper::isResponse($data) ? $data : $this->afterCreate(array($data));
    }

    protected function getFilePathInformation($public,$path,$filename) : array{
        $disk = 'public';
        if($public === false)  $disk = 'private';

        $url = "$path{$filename}";
        $diskPath = "pages${url}";

        $location = "app/{$disk}/{$diskPath}";

        if(!$public){
            $url = "cms/pages{$url}";
        }

        return [
            'disk' => $disk,
            'url' => $url,
            'location' => $location,
            'diskPath' => $diskPath
        ];
    }

    protected function createOne($create){
        $html = $this->request->getInput('html');
        if(!$html){
            return $this->respond(['message' => 'no html given'],400);
        }

        $info = $this->getFilePathInformation($create['public'],$create['path'],$create['filename']);
        $create['url'] = $info['url'];
        $create['disk'] = $info['disk'];
        $create['location'] = $info['location'];
        $create['diskPath'] = $info['diskPath'];
        $entry = parent::createOne($create);

        Storage::disk($entry->disk)->put($entry->diskPath,$html);

        return $entry;
    }

    protected function editOne($entry,$editData){
        $html = $this->request->getInput('html');
        $original = $entry->replicate();

        $entry = parent::editOne($entry,$editData);
        $info = $this->getFilePathInformation($entry->public,$entry->path,$entry->filename);

        $entry->url = $info['url'];
        $entry->disk = $info['disk'];
        $entry->location = $info['location'];
        $entry->diskPath = $info['diskPath'];
        $entry->save();

        if($html !== false){
            Storage::disk($original->disk)->delete($original->diskPath);
            Storage::disk($entry->disk)->put($entry->diskPath,$html);
            return $entry;
        }

        if($entry->disk !== $original->disk){
            $file = Storage::disk($original->disk)->get($original->diskPath);
            Storage::disk($entry->disk)->put($entry->diskPath,$file);
            Storage::disk($original->disk)->delete($original->diskPath);
        }
        else if($entry->name !== $original->name){
            Storage::disk($entry->disk)->move($original->diskPath,$entry->diskPath);
        }

        return $entry;
    }

    protected function deleteOne($entry){
        parent::deleteOne($entry);
        Storage::disk($entry->disk)->delete($entry->diskPath);
    }

    private function getFilePath($query){
        $data = $this->read($query);

        if($data->count() > 0){
            $file = $data->first();
            $filepath = storage_path($file->location);
            return $filepath;
        }

        return false;
    }

    public function getFileByUrl($fileUrl){
        $file = $this->getFilePath(['url' => $fileUrl]);

        if($file !== false) return response()->file($file);
        abort(404);
    }

    public function getFileByID($id){
        $file = $this->getFilePath(['id' => $id]);

        if($file !== false) return response()->file($file);
        abort(404);
    }
}
