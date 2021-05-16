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

    // all fillable attributes
    public $fillable = [];
    // array with all default values for attributes
    public $attributes = [];
    // array that determines what datatype certain attributes should be cast to
    public $casts = [];
    // attributes that do not appear in the api response
    public $hidden = [];
    // all attribute that appear in the api response
    public $visible = [];

    public function __construct($parent = null,$children = []){
        $this->setPaths();
        $this->name = Helper::toSnakeCase($this->name);
        $this->parent = $parent;
        $this->children = $children;
        $this->setPlural();
        $this->setTable();
        $this->createFillable($this->table);
        $this->createAttributes();
        $this->createCasts();
        $this->createHidden();
        $this->createVisible();
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

    private function createFillable(){
        $fillable = $this->getFillable();
        $this->fillable = $this->mapByColumnName($fillable);
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

    private function createVisible(){
        $visible = array_filter($this->getAll(),function($value){
            return $value->hidden === false;
        });

        $this->visible = $this->mapByColumnName($visible);
    }

    private function createHidden(){
        $filter = array_filter($this->getAll(),function($value){
            return $value->hidden === true;
        });

        $this->hidden = $this->mapByColumnName($filter);
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

    public function getColumn($name){
        $array = $this->getAll();

        $column = array_filter($array,function($value) use ($name){
            return $value->getDatabaseColumnName() === $name;
        });

        if(count($column) > 0){
            return array_values($column)[0];
        }

        return null;
    }

    private function mapByColumnName($array){
        return array_values(array_map(function($value){
            return $value->getDatabaseColumnName();
        },$array));
    }
}
