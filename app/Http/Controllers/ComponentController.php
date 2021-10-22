<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\MainController;
use App\Tables\ComponentTable;
use App\Http\Validators\ComponentValidator;
use Illuminate\Database\Eloquent\Builder;

class ComponentController extends MainController{
    public function __construct(){
        $this->table = new ComponentTable();
        $this->validator = new ComponentValidator();
        parent::__construct();
    }

    protected function deleteOne($component) {
        // The Nav and Footer components cannot be deleted
        if($component->name === 'Footer' || $component->name === 'Navbar') {
            return;
        }

        return parent::deleteOne($component);
    }
}
