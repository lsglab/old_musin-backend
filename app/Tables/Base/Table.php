<?php

namespace App\Tables\Base;

use Illuminate\Support\Collection;
use App\Tables\Base\Columns\Column;

class Table
{
    //the namespace path of the table (e.g if the class name is User the table is App/Models/User);
    public string $path;
    //the name of the table
    public string $name;
    //the plural name of the table (e.g if the table name is "user", the plural should be "users")
    public ?string $plural = null;
    //the table it should be associated with
    public ?string $table = null;
    //if a table has a parent it will enable an inherticance of the parents permissions
    public $parent = null;
    //the children of the table,this should be all tables where the parent is this table;
    public array $children = [];
    //this array should contain all columns
    public array $columns = [];
    //this array defines all relations of a table with other tables
    public $relations = [];

    //See eloquent docs: https://laravel.com/docs/8.x/eloquent
    public $fillable = [];
    public $attributes = [];
    public $casts = [];
    public $hidden = [];

    public function __construct($parent = null,$children = []){
        $this->name = $this->toSnakeCase($this->name);
        $this->plural = $this->toSnakeCase($this->plural);
        $this->parent = $parent;
        $this->children = $children;
        $this->setPlural();
        $this->setTable();
        $this->createFillable($this->table);
        $this->createAttributes();
        $this->createCasts();
        $this->createHidden();
    }

    private function setPlural(){
        if($this->plural === null){
            $this->plural = $this->name."s";
        }
    }

    private function setTable(){
        if($this->table === null){
            $this->table = $this->plural;
        }
    }

    private function createFillable(){
        $fillable = $this->getFillable();
        $this->fillable = array_values(array_map(function($value){
            return $value->getDatabaseColumnName();
        },$fillable));
    }

    private function createAttributes(){
        $filter = array_filter($this->columns,function($value){
            return $value->default !== null;
        });
        foreach($filter as $column){
            $this->attributes[$column->name] = $column->default;
        }
    }

    private function createCasts(){
        $filter = array_filter($this->columns,function($value){
            $value->getCast() !== false;
        });

        foreach($filter as $column){
            $this->casts[$column->name] = $column->getCast();
        }
    }

    private function createHidden(){
        $filter = array_filter($this->getAll(),function($value){
            return $value->hidden === true;
        });

        $this->hidden = array_values(array_map(function($value){
            return $value->getDatabaseColumnName();
        },$filter));
    }

    public function getAll(){
        return array_merge($this->columns,$this->relations);
    }

    public function getFillable(){
        $fillable = array_filter($this->columns,function($value){
            return $value->fillable === true;
        });

        $relations = array_filter($this->relations,function($value){
            return $value->getBaseType() === 'belongs_to';
        });

        return array_merge($fillable,$relations);
    }

    private function toSnakeCase($string){
        $type = gettype($string);
        if(gettype($string) === 'string'){
            preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $string, $matches);
            $ret = $matches[0];
            foreach ($ret as &$match) {
                $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
            }
            return implode('_', $ret);
        }
        return $string;
    }
}
