<?php

namespace App\Models\Trainings\Evaluations;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static create(array $array)
 * @method static where(string $string, string $string1, $id)
 * @method static whereHas(string $string, \Closure $param)
 */
class EvaluationStatus extends Model{
    use HasFactory;

    protected $table = 'evaluations__statuses';
    protected $guarded = ['id'];

    public function evaluationRel(): HasOne{
        return $this->hasOne(Evaluation::class, 'id', 'evaluation_id');
    }

    public function userRel(): HasOne{
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
