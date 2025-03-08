<?php

namespace App\Models\Trainings\Evaluations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 * @method static where(string $string, string $string1, $id)
 */
class EvaluationStatus extends Model{
    use HasFactory;

    protected $table = 'evaluations__statuses';
    protected $guarded = ['id'];
}
