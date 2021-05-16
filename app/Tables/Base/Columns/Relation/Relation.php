<?php

namespace App\Tables\Base\Columns\Relation;
use App\Tables\Base\Columns\Column;

class Relation extends Column{

    //path to the foreign table which it has a relation with;
    public string $foreign_table;
    //the type of relation. Valid types are: has_many,belongs_to,polymorphic_has_many,polymorphic_belongs_to
    public string $relation_type;
    /*the name of relation it shoudl be accessed with (e.g if the roles as many users than the
    function name should be "users")*/
    public string $function_name;

    public function __construct($table,$foreign_table,$name,$relation_type,$function_name = null,$object=null){
        parent::__construct($table,$name,'relation',$object=null);
        $this->foreign_table = $foreign_table;
        $this->relation_type = $relation_type;
        $this->setFunctionName($function_name);
    }

    private function instanciateForeignModel(){
        if($this->foreign_table !== null){
            $this->foreign_table = new $this->foreign_table;
        }
    }

    public function getFunctionName(){
        $this->foreign_table = new $foreign_table;
        $this->setFunctionName();
        return $this->function_name;
    }

    private function setFunctionName($name){}

    public function getBaseType(){}

    public function get($table){}
}
