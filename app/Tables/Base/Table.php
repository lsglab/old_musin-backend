<?php

namespace App\Tables\Base;

use Illuminate\Support\Collection;
use App\Tables\Base\Columns\Column;
use App\Helper;

abstract class Table
{
    //the name of the table
    public string $name;
    //the namespace path of the controller that belongs to this table
    public ?string $controller = null;
    //the namespace path of the model that belongs to this table
    public ?string $model = null;
    //the namespace path of the table (e.g if the class name is User the table is App/Tables/User);
    public ?string $path = null;
    //the plural name of the table (e.g if the table name is "user", the plural should be "users")
    public ?string $plural = null;
    //the table it should be associated with
    public ?string $table = null;

    //if a table has a parent it will enable an inherticance of the parents permissions
    public ?string $parent = null;
    //the children of the table,this should be all tables where the parent is this table;
    public array $children = [];

    //this array should contain all columns
    public array $columns = [];
    //this array defines all relations of a table with other tables
    public $relations = [];


    // array with all default values for attributes
    public $attributes = [];
    // array that determines what datatype certain attributes should be cast to
    public $casts = [];
    // vars that should not be in the json
    private array $exclude = ['columns','relations','controller','path','model','parent','children'];

    public function __construct(){
        $this->setPaths();
        $this->name = Helper::toSnakeCase($this->name);
        $this->setPlural();
        $this->setTable();
        $this->createCasts();
    }

    private function setPaths(){
        $name = ucfirst(Helper::toCamelCase($this->name));
        $this->path = Helper::setIfNull($this->path,"App\Tables\\${name}Table");
        $this->model = Helper::setIfNull($this->model,"App\Models\\${name}");
        $this->controller = Helper::setIfNull($this->controller,"App\Http\Controllers\\${name}Controller");
    }

    private function setPlural(){
        if($this->plural === null){
            $this->plural = $this->name."s";
        }
        $this->plural = Helper::toSnakeCase($this->plural);
    }

    private function setTable(){
        if($this->table === null){
            $this->table = $this->plural;
        }
    }

    public function createAttributes(){
        $filter = array_filter($this->columns,function($value){
            return $value->default !== null;
        });
        foreach($filter as $column){
            $this->attributes[$column->name] = $column->default;
        }
    }

    public function createCasts(){
        $filter = array_filter($this->columns,function($value){
            $value->getCast() !== false;
        });

        foreach($filter as $column){
            $this->casts[$column->name] = $column->getCast();
        }
    }

    private function arrayIsNull(?array $array,?array $alternative = null) : array{
        if($array === null){
            if($alternative === null){
                return $this->getAll();
            }

            return $alternative;
        }
        return $array;
    }

    public function getAll() : array{
        return array_values(array_merge($this->columns,$this->relations));
    }

    public function getVisible(?array $array = null) : array{
        $array = $this->arrayIsNull($array);

        return array_values(array_filter($array,function($value){
            return $value->hidden === false;
        }));
    }

    public function getHidden(?array $array = null) : array{
        $array = $this->arrayIsNull($array);

        return array_values(array_filter($this->getAll(),function($value){
            return $value->hidden === true;
        }));
    }

    public function getFillable(?array $array = null) : array{
        $array = $this->arrayIsNull($array,$this->getTableColumns());

        return array_values(array_filter($array,function($value){
            return $value->fillable === true;
        }));
    }

        //returns all columns that are in the table;
    public function getTableColumns(?array $array = null) : array{
        $array = $this->arrayIsNull($array);

        return array_values(array_filter($array,function($value){
            if($value->type === 'relation'){
                return $value->getBaseType() === 'belongs_to';
            }
            return true;
        }));
    }

    public function getIdentifiers(?array $array = null) : array{
        $array = $this->arrayIsNull($array);

        return array_values(array_filter($array,function($value){
            return $value->identifier === true;
        }));
    }

    public function getColumnNames(array $array) : array{
        return array_values(array_map(function($value){
            return $value->getColumnName();
        },$array));
    }

    public function getColumn($name,?array $array = null){
        $array = $this->arrayIsNull($array);

        $column = array_filter($array,function($value) use ($name){
            return $value->getColumnName() === $name;
        });

        if(count($column) > 0){
            return array_values($column)[0];
        }

        return null;
    }

    public function toArray(){
        $array = Helper::objectToArray($this,$this->exclude);
        $extras = ['columns','relations'];
        foreach($extras as $ele){
            $array[$ele] = array_map(function($value){
                return $value->toArray();
            },$this->$ele);
        }
        $array['parent'] = $this->parent === null ? $this->parent : $this->getTable($this->parent);
        $array['children'] = [];
        foreach($this->children as $child){
            array_push($array['children'],$this->getTable($child));
        }
        return $array;
    }
}
