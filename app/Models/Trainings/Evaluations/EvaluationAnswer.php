<?php

namespace App\Models\Trainings\Evaluations;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EvaluationAnswer extends Model{
    use HasFactory;

    protected $table = 'evaluations__answers';
    protected $guarded = ['id'];

    public function evaluationRel(): HasOne{
        return $this->hasOne(Evaluation::class, 'id', 'evaluation_id');
    }
    public function optionRel(): HasOne{
        return $this->hasOne(EvaluationOption::class, 'id', 'option_id');
    }
    public function userRel(): HasOne{
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
