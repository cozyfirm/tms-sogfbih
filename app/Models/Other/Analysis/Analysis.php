<?php

namespace App\Models\Other\Analysis;

use App\Models\Trainings\Evaluations\Evaluation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static orderBy(string $string, string $string1)
 * @method static create(array $except)
 * @method static where(string $string, string $string1, $id)
 */
class Analysis extends Model{
    use HasFactory, SoftDeletes;

    protected $table = 'analysis';
    protected $guarded = ['id'];

    public function dateFrom(): string{
        return Carbon::parse($this->date_from)->format('d.m.Y');
    }
    public function dateTo(): string{
        return Carbon::parse($this->date_to)->format('d.m.Y');
    }
    public function evaluationRel(): HasOne{
        return $this->hasOne(Evaluation::class, 'model_id', 'id')->where('type', '=', '__analysis');
    }
}
