<?php

namespace App\Models\Other\Analysis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static where(string $string, string $string1, $id)
 * @method static whereHas(string $string, \Closure $param)
 */
class AEAnswer extends Model{
    use HasFactory;

    protected $table = 'evaluations__analysis_answers';
    protected $guarded = ['id'];

    public function analysisEvaluationRel(): HasOne{
        return $this->hasOne(AnalysisEvaluation::class, 'id', 'analytics_id');
    }
}
