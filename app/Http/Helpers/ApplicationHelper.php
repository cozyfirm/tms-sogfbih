<?php

use App\Models\Trainings\Instances\InstancePresence;

class ApplicationHelper{
    public static function isPresent($id, $date): bool{
        return InstancePresence::where('application_id', '=', $id)->where('date', '=', $date)->count() > 0;
    }
}
