<?php

namespace App;

class Helper
{

    public static function toArray($var){
        $type = gettype($var);

        if(!is_iterable($var)){
            return array($var);
        } else {
            return $var;
        }
    }

    public static function toSnakeCase($string){
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

    public static function toCamelCase($str) {
        $i = array("-","_");
        $str = preg_replace('/([a-z])([A-Z])/', "\\1 \\2", $str);
        $str = preg_replace('@[^a-zA-Z0-9\-_ ]+@', '', $str);
        $str = str_replace($i, ' ', $str);
        $str = str_replace(' ', '', ucwords(strtolower($str)));
        $str = strtolower(substr($str,0,1)).substr($str,1);
        return $str;
    }

    public static function getEqualObjectsByKey($array1,$array2,$key){
        $return = array();

        $array1 = self::toArray($array1);
        $array2 = self::toArray($array2);

        foreach($array1 as $ele1){
            foreach($array2 as $ele2){
                if($ele1->$key === $ele2->$key){
                    array_push($return,$ele1);
                }
            }
        }

        return $return;
    }

    public static function isResponse($data){
        if(gettype($data) !== 'object'){
            return false;
        }
        if(get_class($data) === 'Illuminate\Http\JsonResponse'){
            return true;
        }
        return false;
    }

    public static function setIfNull(&$var,$value){
        if($var === null){
            $var = $value;
            return $var;
        }

        return $var;
    }

    public static function objectToArray($object,$exclude = []){
        $vars = get_object_vars($object);
        $array = [];

        foreach($vars as $key => $value){
            if(!in_array($key,$exclude)){
                $array[$key] = $object->$key;
            };
        }

        return $array;
    }
}
