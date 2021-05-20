<?php

namespace App\Models\Base;


class ModelFunctions{

    public static function construct($model){
        $model->hidden = $model->t_table->getColumnNames($model->t_table->getHidden($model->t_table->getTableColumns()));
        $model->fillable = $model->t_table->getColumnNames($model->t_table->getFillable());
        $model->casts = $model->t_table->casts;
        $model->attributes = $model->t_table->attributes;
        $model->table = $model->t_table->table;

        foreach($model->t_table->relations as $relation){
            $functionName = $relation->getFunctionName();
            $model->$functionName = function() use ($model,$functionName){
                return self::getRelation($model,$functionName);
            };
        }
    }

    public static function getRelation($model,$name){
        $relation = array_values(array_filter($model->t_table->relations,function($value) use ($name){
            return $value->getFunctionName() === $name;
        }));

        if(count($relation) > 0){
            $relation = $relation[0];
            $data = $relation->get($model)->values();

            if(count($data) === 1){
                return $data[0];
            }

            return $data;
        }

        return [];
    }
}
