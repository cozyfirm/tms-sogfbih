<?php

use App\Models\Users\TrainerArea;

class UserHelper{

    public static function isSelected($userID, $areaID){
        return TrainerArea::where('user_id', '=', $userID)->where('area_id', '=', $areaID)->count();
    }
}
