<?php

use App\Models\Trainings\TrainingArea;

class TrainingHelper{
    public static function isSelected($trainingID, $areaID){
        return TrainingArea::where('training_id', '=', $trainingID)->where('area_id', '=', $areaID)->count();
    }
}
