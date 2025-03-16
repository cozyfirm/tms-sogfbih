<?php

namespace App\Models\Other\Analysis;

use App\Traits\Common\CommonTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $string1, mixed $evaluation_id)
 * @method static create(array $array)
 */
class EvaluationAnalysis extends Model{
    use HasFactory, CommonTrait;

    protected $table = 'evaluations__analysis';
    protected $guarded = ['id'];

    public function createdAt(): string{
        return $this->date($this->created_at);
    }
}
