<?php

namespace App\Models\Base;


class ModelFunctions{

    public static function getHidden($model){
        return $model->t_table->getColumnNames($model->t_table->getHidden($model->t_table->getTableColumns()));
    }

    public static function getFillable($model){
        return $model->t_table->getColumnNames($model->t_table->getFillable());
    }

    public static function getCasts($model){
        return $model->t_table->casts;
    }

    public static function getAttributes($model){
        return $model->t_table->attributes;
    }

    public static function getTable($model){
        return $model->t_table->table;
    }



    public static function getRelation($model,$name){
        $relation = array_values(array_filter($model->t_table->relations,function($value) use ($name){
            return $value->getFunctionName() === $name;
        }));

        if(count($relation) > 0){
            $relation = $relation[0];
            $data = $relation->get($model);

            return $data;
        }

        return [];
    }
}
