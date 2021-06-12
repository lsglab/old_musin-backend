<?php

namespace App\Tables\Base\Columns;
use Illuminate\Validation\Rule;
use App\Rules\CompositeUnique;
use Illuminate\Database\Schema\Blueprint;
use App\Helper;

abstract class Column{

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
    // should this column be used as the default display value for this table
    public bool $isDisplayValue = false;
    // a default value for the column, can be of any type
    public mixed $default = null;
    // properties that should not returned in api response;
    protected array $exclude = ['table'];

    public function __construct($table,$name,$object=null){
        $this->table = $table;
        $this->name = $name;

        $this->assignDisplayValue($object);
        $this->assignIfNotNull($object,'unique');
        $this->assignIfNotNull($object,'required');
        $this->assignIfNotNull($object,'identifier');
        $this->assignIfNotNull($object,'hidden');
        $this->assignIfNotNull($object,'fillable');
        $this->assignIfNotNull($object,'default');
    }

    private function assignDisplayValue($object){
        if(!$this->assignIfNotNull($object,'isDisplayValue')){
            if($this->name === 'name'){
                $this->isDisplayValue = true;
            }
        }
    }

    private function assignIfNotNull($object,$key){
        if($object !== null && array_key_exists($key,$object)){
            $this->$key = $object[$key];
            return true;
        }

        return false;
    }

    //this function should return the name of the column that is in the database
    public function getColumnName() : string{
        return $this->name;
    }

    //returns what type the value should be cast to. If it returns an empty string nothing happens;
    public function getCast() : string{
        return '';
    }

    public function cast($value){
        return $value;
    }

    public function modifyValue($value){
        return $value;
    }

    protected function isRequired($required,$object) : array{
        if($required){
            return ['required'];
        } else {
            return ['nullable'];
        }
    }

    protected function isUnique($unique,$exists,$object) : array{
        if($unique && !$exists){
            $string = "unique:".$this->table->table;
            return [$string];
        }
        if($unique && $exists){
            $rule = Rule::unique($this->table->table)->ignore($object->id);
            return [$rule];
        }

        return [];
    }

    protected function isIdentifier($identifier) : array{
        if($identifier){
            $identifiers = $this->table->getColumnNames($this->table->getIdentifiers());

            $composite = new CompositeUnique($this->table->table,$identifiers);
            return [$composite];
        }
        return [];
    }

    public function editValidation($object) : array{
        $required = $this->isRequired(false,$object);
        $type = $this->getTypeValidation($object);
        $unique = $this->isUnique($this->unique,true,$object);
        $identifier = $this->isIdentifier($this->identifier);

        $validation = array();
        return array_merge($validation,$required,$type,$unique,$identifier);
    }

    public function createValidation($object) : array{
        $required = $this->isRequired($this->required,$object);
        $type = $this->getTypeValidation($object);
        $unique = $this->isUnique($this->unique,false,$object);
        $identifier = $this->isIdentifier($this->identifier);

        $validation = array();
        return array_merge($validation,$required,$type,$unique,$identifier);
    }

    //the type specific validation for each column
    protected function getTypeValidation($object) : array{
        return [$this->type];
    }

    protected function createDBColumnType(Blueprint $table){
        return $table;
    }

    public function createDBColumn($table){
        $table = $this->createDBColumnType($table);
        if($this->unique){
            $table = $table->unique();
        }
        if(!$this->required){
            $table = $table->nullable();
        }
        return $table;
    }

    public function toArray(){
        $array = Helper::objectToArray($this,$this->exclude);
        $array['table'] = $this->table->table;
        return $array;
    }
}
