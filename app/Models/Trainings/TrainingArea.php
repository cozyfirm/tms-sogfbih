<?php

namespace App\Models\Trainings;

use App\Models\Core\Keyword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static where(string $string, string $string1, $trainingID)
 * @method static create(array $array)
 */
class TrainingArea extends Model{
    use HasFactory;

    protected $table = 'trainings__areas';
    protected $guarded = ['id'];

    public function areaRel(): HasOne{
        return $this->hasOne(Keyword::class, 'id', 'area_id');
    }
}
