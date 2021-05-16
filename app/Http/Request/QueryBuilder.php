<?php

namespace App\Http\Request;

use App\Http\Request\Request;

class QueryBuilder{

    private Request $request;
    private $table;
    public $builder;
    private $query;
    private array $searchColumns;

    public function __construct(Request $request,$table){
        $this->request = $request;
        $this->table = $table;
        $this->searchColumns = $this->table->visible;
    }

    private function setQuery($query){
        $this->query = $query;

        if($query === null){
            $this->query = $this->request->getQuery();
        }
    }

    private function setBuilder($builder){
        $this->builder = $builder;

        if($this->builder === null){
            //if the builder is null, make a new builder and add a pointless wehre statement;
            $this->builder = $this->table->model::where('id','!=',-1);
        }
    }

    function get($builder = null,$query = null){
        $this->setBuilder($builder);
        $this->setQuery($query);
        //if no query is given there is no need to proceed further;
        if(!$this->query){
            return $this->builder->get();
        }

        foreach($this->query as $key => $value){
            /*handle the special keys search and orderBy;
            also check that the key is in the visible columns, if this is not the case the builder will return
            nothing*/
            if($key==='search'){
                $this->builder = $this->search($value);
            } else if($key === 'orderBy'){
                $this->builder = $this->orderBy($value);
            }
            else if(in_array($key,$this->searchColumns)){
                $this->builder = $this->defaultSearch($key,$value);
            } else {
                //just add a query that always fails -> empty array is returned
                $this->builder = $this->builder->where('id',-1);
            }
        }

        return $this->builder->get();
    }

    private function defaultSearch($key,$value){
        //if the value is null, make a where Null check
        if($value === "null"){
            return $this->builder->whereNull($key);
        }
        //otherwise standard where
        return $this->builder->where($key,$value);
    }

    private function orderBy($value){
        /*split the string
        The first part is the column to sort by the second is the sort method
        The sort methods default is asceding;
        */
        $split = explode(',',$value);
        $method = 'asc';
        if(count($split) > 1){
            $method = $split[1] == 'desc' || $split[1] == 'asc' ? $split[1] : $method;
        }
        $column = $split[0];

        if(in_array($column,$this->searchColumns)){
            return $this->builder->orderBy($column,$method);
        }
        return $this->builder;
    }

    private function search($searchValue){
        $searchColumns = $this->searchColumns;
        return $this->builder->where(function($query) use ($searchColumns,$searchValue){
            foreach($searchColumns as $column){
                $query = $query->orWhere($column,'like','%'.$searchValue.'%');
            }
        });
    }
}
