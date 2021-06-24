<?php

namespace App\Http\Request;

use App\Http\Request\Request;

class QueryBuilder{

    public $builder;
    public Request $request;
    protected $table;
    protected $query;
    protected array $searchColumns;

    public function __construct(Request $request,$table){
        $this->request = $request;
        $this->table = $table;
        $this->searchColumns = $this->table->getVisible($this->table->getTableColumns());
    }

    protected function setQuery($query){
        $this->query = $query;

        if($query === null){
            $this->query = $this->request->getQuery();
        }
    }

    protected function setBuilder($builder){
        $this->builder = $builder;

        if($this->builder === null){
            //if the builder is null, make a new builder and add a pointless wehre statement;
            $this->builder = $this->table->model::where('id','!=',-1);
        }
    }

    public function get($builder = null,$query = null){
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
            if($key==='_search'){
                $this->builder = $this->search($value);
            } else if($key === '_orderBy'){
                $this->builder = $this->orderBy($value);
            }
            else if(in_array($key,$this->table->getColumnNames($this->searchColumns))){
                $this->builder = $this->defaultSearch($key,$value);
            }
        }

        return $this->builder->get();
    }

    private function defaultSearch($key,$value){
        //if the value is null, make a where Null check
        if($value === "null"){
            return $this->builder->whereNull($key);
        }
        //cast values to their right datatypes, e.g a "true" gets cast to true if
        //the column type is boolean
        $value = $this->table->getColumn($key,$this->searchColumns)->castValue($value);

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
