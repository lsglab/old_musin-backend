<?php

namespace App\Models\Base;

interface ModelInterface{

    public function __construct(array $attributes = []);

    public function getRelation($name);

    public function __call($name,$attributes);
}
