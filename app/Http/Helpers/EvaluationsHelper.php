<?php

use App\Models\Other\Analysis\EvaluationAnalyticsAnswer;
use App\Models\Trainings\Evaluations\EvaluationAnswer;

class EvaluationsHelper{

    public static function isChecked($evaluation_id, $option_id): mixed{
        $answer = EvaluationAnswer::where('evaluation_id', '=', $evaluation_id)->where('option_id', '=', $option_id)->where('user_id', '=', Auth()->user()->id)->first();
        if(!$answer) return 6;
        else{
            if($answer->answer == 0) return 6;
            else return $answer->answer;
        }
    }

    public static function getAnswer($evaluation_id, $option_id): mixed{
        $answer = EvaluationAnswer::where('evaluation_id', '=', $evaluation_id)->where('option_id', '=', $option_id)->where('user_id', '=', Auth()->user()->id)->first();
        return $answer->answer ?? '';
    }

    /**
     *  Questionnaire for public part (not logged users)
     */
    public static function pIsChecked($evaluation_id, $option_id, $analysis_id): mixed{
        $answer = EvaluationAnalyticsAnswer::where('evaluation_id', '=', $evaluation_id)->where('option_id', '=', $option_id)->where('analytics_id', '=', $analysis_id)->first();
        if(!$answer) return 6;
        else{
            if($answer->answer == 0) return 6;
            else return $answer->answer;
        }
    }
    public static function pGetAnswer($evaluation_id, $option_id, $analysis_id): mixed{
        $answer = EvaluationAnalyticsAnswer::where('evaluation_id', '=', $evaluation_id)->where('option_id', '=', $option_id)->where('analytics_id', '=', $analysis_id)->first();
        return $answer->answer ?? '';
    }
}
