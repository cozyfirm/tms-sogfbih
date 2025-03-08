<?php

namespace App\Models\Trainings\Evaluations;

use App\Models\Core\Keyword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static create(array $array)
 * @method static where(string $string, string $string1, $id)
 */
class EvaluationOption extends Model{
    use HasFactory;

    protected $table = 'evaluations__options';
    protected $guarded = ['id'];

    public function groupRel(): HasOne{
        return $this->hasOne(Keyword::class, 'id', 'group_by');
    }
    public function typeRel(): HasOne{
        return $this->hasOne(Keyword::class, 'value', 'type')->where('type', 'evaluation__question_type');
    }
    public function evaluationRel() : HasOne{
        return $this->hasOne(Evaluation::class, 'id', 'evaluation_id');
    }
    public function answersRel(): HasMany{
        return $this->hasMany(EvaluationAnswer::class, 'option_id', 'id');
    }

    /**
     *  For user evaluations GUI
     */
    public function getByGroupWithAnswers($evaluation, $group_id){
        return EvaluationOption::where('evaluation_id', '=', $evaluation)->where('group_by', '=', $group_id)->where('type', 'with_answers')->get();
    }
    public function getByGroupQuestionOnly($evaluation, $group_id){
        return EvaluationOption::where('evaluation_id', '=', $evaluation)->where('group_by', '=', $group_id)->where('type', 'question_only')->get();
    }
}
