<?php

namespace App\Tables\Base\Columns\Relation;
use App\Tables\Base\Columns\Column;

abstract class Relation extends Column{

    //path to the foreign table which it has a relation with;
    protected $foreignTable;
    //the type of relation. Valid types are: has_many,belongs_to,polymorphic_has_many,polymorphic_belongs_to
    public string $relationType;
    /*the name of relation it shoudl be accessed with (e.g if the roles as many users than the
    function name should be "users")*/
    protected ?string $functionName;

    protected array $exclude = ['table','foreignTable'];

    public function __construct($table,$foreignTable,$name,$relationType,$functionName = null,$object=null){
        parent::__construct($table,$name,$object);
        $this->type = 'relation';
        $this->foreignTable = $foreignTable;
        $this->relationType = $relationType;
        $this->functionName = $functionName;
    }

    public function getForeignTable($entry = null){
        if($this->foreignTable !== null && gettype($this->foreignTable) === 'string'){
            $this->foreignTable = new $this->foreignTable;
        }
        return $this->foreignTable;
    }

    public function getFunctionName(){
        if($this->functionName === null){
            $this->getForeignTable();
            $this->setFunctionName();
        }
        return $this->functionName;
    }

    protected function setFunctionName(){}

    public function getBaseType(){}

    public function get($model){}

    protected function getTypeValidation($object) : array{
        return [];
    }

    public function toArray(){
        $array = parent::toArray();
        $array['functionName'] = $this->getFunctionName();
        $array['baseType'] = $this->getBaseType();
        $foreignTable = $this->getForeignTable();
        if($foreignTable !== null){
            $array['foreignTable'] = $foreignTable->table;
        }
        else {
            $array['foreignTable'] = $foreignTable;
        }
        return $array;
    }
}
