<?php

namespace App\Observers\Base;

class MainObserver extends BaseObserver{

    public function creating($data){
        $data = parent::creating($data);
        $user = auth()->user();

        if($user === null){
            $user = 1;
        } else {
            $user = $user->id;
        }

        $data->creator_id = $user;
        return $data;
    }
}
