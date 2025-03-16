<?php

namespace App\Models\Other\Analysis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $string1, $evaluation_id)
 * @method static create(array $array)
 */
class EvaluationAnalyticsAnswer extends Model{
    use HasFactory;

    protected $table = 'evaluations__analysis_answers';
    protected $guarded = ['id'];
}
