<?php

namespace App\Models\Other\Analysis;

use App\Models\User;
use App\Traits\Common\CommonTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function userRel(): HasOne{
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
