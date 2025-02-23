<?php

use App\Models\Trainings\TrainingArea;
use App\Models\Trainings\TrainingParticipant;

class TrainingHelper{

    /**
     * Check if this particular area is selected
     * @param $trainingID
     * @param $areaID
     * @return mixed
     */
    public static function isSelected($trainingID, $areaID){
        return TrainingArea::where('training_id', '=', $trainingID)->where('area_id', '=', $areaID)->count();
    }

    public static function isParticipantSelected($trainingID, $participantID){
        return TrainingParticipant::where('training_id', '=', $trainingID)->where('participant_id', '=', $participantID)->count();
    }
}
