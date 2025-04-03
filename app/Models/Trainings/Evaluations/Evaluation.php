<?php

namespace App\Models\Trainings\Evaluations;

use App\Models\Core\Keyword;
use App\Models\Other\Analysis\EvaluationAnalysis;
use App\Models\Trainings\Training;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * @method static where(string $string, string $string1, $evaluation_id)
 * @method static orderBy(string $string, string $string1)
 * @method static create(array $array)
 */
class Evaluation extends Model{
    use HasFactory, SoftDeletes;

    protected $table = 'evaluations';
    protected $guarded = ['id'];

    public function typeRel(): HasOne{
        return $this->hasOne(Keyword::class, 'value', 'type')->where('type', 'evaluation__type');
    }
    public function lockedRel(): HasOne{
        return $this->hasOne(Keyword::class, 'value', 'locked')->where('type', 'yes_no');
    }
    public function modelRel(): hasOne{
        if($this->type == '__training'){
            return $this->hasOne(Training::class, 'id', 'model_id');
        }
    }
    public function optionsRel(): HasMany{
        return $this->hasMany(EvaluationOption::class, 'evaluation_id', 'id');
    }

    public function myEvaluation(): HasOne{
        return $this->hasOne(EvaluationStatus::class, 'evaluation_id', 'id')->where('user_id', '=', Auth::user()->id);
    }
    /** Evaluations */
    public function statusesRel(): HasMany{
        return $this->hasMany(EvaluationStatus::class, 'evaluation_id', 'id');
    }
    /** Public questionnaires */
    public function publicQuestionnairesRel(): HasMany{
        return $this->hasMany(EvaluationAnalysis::class, 'evaluation_id', 'id')->where('status', '=', 'submitted')->orderBy('id', 'DESC');
    }
    public function publicQuestionnairesAllRel(): HasMany{
        return $this->hasMany(EvaluationAnalysis::class, 'evaluation_id', 'id');
    }
}
