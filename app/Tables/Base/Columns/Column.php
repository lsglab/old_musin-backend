<?php

namespace App\Tables\Base\Columns;

class Column{

    //the table this column belongs to
    public $table;
    //name of the column
    public string $name;
    //type of the column
    public string $type;
    //if a column is unique its value can only exist once in the table
    public bool $unique = false;
    //if a column is required it must be given when creating a new entry
    public bool $required = true;
    //several columns that are identifiers form a composite primary together
    public bool $identifier = false;
    //if a column is hidden it is not returned in the api response
    public bool $hidden = false;
    // if fillable is false it cannot be modified via requests
    public bool $fillable = true;
    // a default value for the column, can be of any type
    public $default = null;

    public function __construct($table,$name,$type,$object=null){
        $this->table = $table;
        $this->name = $name;
        $this->type = $type;
        $this->assignIfNotNull($object,'unique');
        $this->assignIfNotNull($object,'required');
        $this->assignIfNotNull($object,'identifier');
        $this->assignIfNotNull($object,'hidden');
        $this->assignIfNotNull($object,'fillable');
        $this->assignIfNotNull($object,'default');
    }

    private function assignIfNotNull($object,$var){
        if($object !== null && $object->$key != null){
            $this->$var = $object->$var;
        }
    }

    //this function should return the name of the column that is in the database
    public function getDatabaseColumnName() : string{
        return $this->name;
    }

    //returns what type the value should be cast to. If it returns false no cast happens;
    public function getCast(){
        return false;
    }

    //the type specific validation for each column
    public function getValidation() : array{
        return [$this->type];
    }
}
