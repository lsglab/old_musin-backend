<?php

namespace App\Observers\Base;

abstract class BaseObserver{

    private function getHidden($data){
        return $data->t_table->getColumnNames($data->t_table->getHidden($data->t_table->getTableColumns()));
    }

    protected function makeVisible($data){
        $hidden = $this->getHidden($data);

        $data = $data->makeVisible($hidden);

        foreach($hidden as $attr){
            $data->$attr = $data->$attr;
        }
        return $data;
    }

    protected function makeHidden($data){
        $hidden = $this->getHidden($data);

        $data = $data->makeHidden($hidden);

        return $data;
    }

    protected function modifyData($data){
        foreach($data->getAttributes() as $key => $value){
            $column = $data->t_table->getColumn($key);

            if($column !== null){
                $data[$key] = $column->modifyValue($value);
            }
        }
        return $data;
    }

    protected function modify($data){
        /*make hidden property visible in order to edit them (this is useful when converting
        passwords to hashes)*/
        $data = $this->makeVisible($data);
        /*modify the data*/
        $data = $this->modifyData($data);
        /*afterwards hide the attributes that should be hidden, otherwise they would appear in the api response*/
        $data = $this->makeHidden($data);
        return $data;
    }

    public function creating($data){
        return $this->modify($data);
    }

    public function created($data){
        //
    }

    public function updating($data){
        return $this->modify($data);
    }


    public function updated($data)
    {
        //
    }


    public function deleted($data)
    {
        //
    }


    public function restored($data)
    {
        //
    }


    public function forceDeleted($data)
    {
        //
    }
}
