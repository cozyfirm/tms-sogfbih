<?php

namespace App\Models\Users;

use App\Models\Core\Keyword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static where(string $string, string $string1, mixed $user_id)
 * @method static create(array $array)
 */
class TrainerArea extends Model{
    use HasFactory;

    protected $table = 'users__trainer_areas';
    protected $guarded = ['id'];

    public function areaRel(): HasOne{
        return $this->hasOne(Keyword::class, 'id', 'area_id');
    }
}
