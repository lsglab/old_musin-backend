<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\generated\Role;
use App\Models\generated\Permission;
use App\Models\Subject;

class getPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){

        $action = $this->getAction($request);
        $subject = $this->getSubject($this->getPath($request));
        $roleId  = auth()->user()->role_id;
        $permission = $this->getPermission($roleId,$subject->id,$action);

        //if the permission does not exist check for the self permission of the action
        // (except if the action is create)
        if(!$permission){
            $authorized = false;

            if($action !== 'create'){
                $action = "{$action}-self";

                $permission = $this->getPermission($roleId,$subject->id,$action);
                //if the user has the permission let him pass
                if($permission !== false){
                    $authorized = true;
                }
            }

            if(!$authorized){
                return $this->respond(['message' => 'no_permission'],403);
            }
        }

        $request->merge(['userPermission' => $permission->action]);

        return $next($request);
    }

    //convert the request type to an action
    function getAction($request){
        $method = $request->method();

        switch($request->method()){
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

    //function to retrieve the path of the request
    //the split is needed to get rid of the /api part in the path
    function getPath($request){
        $parts = preg_split('[\/]',$request->path(),2);
        return $parts[1];
    }

    //retrieve the subject by path
    //since the path must be unqiue only one result can be returned
    function getSubject($path){
        return Subject::where('table',$path)->first();
    }

    //retrive a role by its name
    function getRole($name){
        return Role::where('name',$name)->first();
    }

    //get a permission by role_id,subject_id and action.
    //If no permission is found, false is returned
    function getPermission($role_id,$subject_id,$action){
        $permission = Permission::where('role_id',$role_id)
            ->where('subject_id',$subject_id)
            ->where('action',$action)
            ->first();

        if($permission === NULL){
            return false;
        }else {
            return $permission;
        }
    }

    function respond($array,$status = 200){
        return response()->json($array,$status);
    }
}
