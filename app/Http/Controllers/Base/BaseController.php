<?php

namespace App\Http\Controllers\Base;

use Illuminate\Support\Facades\DB;
use App\Http\Request\Request;
use App\Http\Request\QueryBuilder;
use App\Helper;

class BaseController extends Controller
{
    protected $table;
    public QueryBuilder $builder;
    protected $validator;
    public Request $request;

    public function __construct(){
        $this->request = new Request();
        $this->builder = new QueryBuilder($this->request,$this->table);
    }

    function respond($array,$status = 200){
        return response()->json($array,$status);
    }

    public function handle($action = null){
        $this->request = new Request();
        if($action === null){
            $action = $this->request->getAction();
        }

        switch($action){
            case 'read':
                return $this->handleRead();
                break;
            case 'edit':
                return $this->handleEdit();
                break;
            case 'delete':
                return $this->handleDelete();
                break;
            case 'create':
                return $this->handleCreate();
                break;
            default:
                return $this->respond(['message' => 'action_does_not_exist'],400);
                break;
        }
    }

    protected function handleRead(){
        $data = $this->read();
        return Helper::isResponse($data) ? $data : $this->afterRead($data);
    }

    protected function handleEdit(){
        $edit = $this->read();
        $data = $this->edit($edit);
        return Helper::isResponse($data) ? $data : $this->afterEdit($data);
    }

    protected function handleDelete(){
        $delete = $this->read();
        $data = $this->delete($delete);
        return Helper::isResponse($data) ? $data : $this->afterDelete($data);
    }

    protected function handleCreate(){
        $body = $this->request->getRequestBody();
        //create wants an array or object as datatype
        if(gettype($body) !== 'array'){
            return $this->respond(['message' => 'Invalid data. Expected object or array'],400);
        }

        $data = array();
        //if an object was given, make it to an array;
        if(!array_key_exists('0',$body)){
            $body = array($body);
        }

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

        return $this->afterCreate($data);
    }

    protected function afterRead($data){
        return $this->processDataAndRespond($data);
    }

    protected function afterEdit($updated){
        $updated = array($updated);
        return $this->processDataAndRespond($updated);
    }

    protected function afterCreate($created){
        return $this->processDataAndRespond($created);
    }

    protected function afterDelete($deleted){
        return $this->processDataAndRespond($deleted);
    }

    protected function processDataAndRespond($data){
        return $this->respond([$this->table => $data]);
    }

    public function read($query = null){
        return $this->builder->get(null,$query);
    }

    protected function edit($edit){
        $count = count($edit);
        //make sure that no more than one element can be edited at a time
        if($count > 1){
            return $this->respond(['message' => 'You can only edit one entry at once'],400);
        } else  if($count == 0){
            return $this->respond(['message' => 'No entry found or no permission to edit'],404);
        }

        $edit = $edit[0];
        //validate the request data
        $validate = $this->validateEdit($edit);

        if($validate !== true){
            return $validate;
        }

        $editData = $this->request->getRequestBody();
        // remove any keys from the request body that are not fillable
        foreach($editData as $key => $value){
            if(!in_array($key,$this->table->getColumnNames($this->table->getFillable($this->table->getTableColumns())))){
                unset($editData[$key]);
            }
        }

        $edit = $this->editOne($edit,$editData);

        return $edit;
    }

    protected function editOne($edit,$editData){
        foreach($editData as $key => $value){
            $edit->$key = $value;
        }
        $edit->save();
        return $edit;
    }

    protected function delete($query){
        $body = $this->request->getRequestBody();
        $delete = array();

        function getQueryEle($query,$id){
            foreach($query as $ele){
                if($ele->id === $id){
                    return $ele;
                }
            }
            return false;
        }

        //only run this code if the body of the request contains an array called "ids"
        if($body != null && array_key_exists('ids',$body)){
            foreach($body['ids'] as $id){
                //make sure the id has a valid type
                if(gettype($id) !== 'integer'){
                    return $this->respond(['message' => 'Id must be of type integer'],400);
                }
                //through comparing the ids in the id array and the result of the search query
                //we achieve that only elements that are in both are being deleted
                $filter = getQueryEle($query,$id);

                if($filter !== false){
                    array_push($delete,$filter);
                }
            }
        } else {
            $delete = $query;
        }

        $count = count($delete);
        //return if no element was found/selected
        if($count == 0){
            return $this->respond(['message' => 'No entry found or no permission to delete'],404);
        }
        //handle delete logic
        foreach($delete as $entry){
            $this->deleteOne($entry);
        }

        return $delete;
    }

    //delete one handles the actual delete logic;
    protected function deleteOne($entry){
        foreach($this->table->children as $child){
            $table = new $child;
            //find the relation between the subject and the children
            //this method of deleting the children assumes that there is a relationship
            //between the parent and children
            $relation = array_filter($table->relations,function($value) use ($entry){
                if($value->relationType === 'polymorphic_belongs_to' || $value->relationType === 'polymorphic_has_many'){
                    return false;
                }
                return $value->getForeignTable($entry)->table === $this->table->table;
            });

            if(count($relation) > 0){
                //if a relationship was found delete all entries from the children table where the foreignKey matches
                //the parent entry
                $relation = array_values($relation)[0];
                DB::delete("delete from $table->table where $relation->name = $entry->id");
            }
        }

        $entry->delete();
    }

    protected function create($create = null){
        //if no data is given take the request input as data;
        if($create == null){
            $create = $this->request->request->all();

            foreach($this->table->getFillable() as $column){
                $name = $column->getColumnName();
                if(array_key_exists($name,$create)){
                    $create[$name] = $column->castValue($create[$name]);
                }
            }
        }
        //validate the data
        $validate = $this->validateCreate($create);

        if($validate !== true){
            return $validate;
        }

        $created = $this->createOne($create);

        return $created;
    }

    //createOne handles the actual creation logic
    protected function createOne($create){
        return $this->table->model::create($create);
    }

    protected function validateEdit($object){
        $response = $this->validator->validateEdit($object);
        return $this->validationResponse($response);
    }

    protected function validateCreate($object){
        $response = $this->validator->validateCreate($object);
        return $this->validationResponse($response);
    }

    protected function validationResponse($response){
        if($response !== true){
            return $this->respond($response,400);
        }
        return true;
    }

}
