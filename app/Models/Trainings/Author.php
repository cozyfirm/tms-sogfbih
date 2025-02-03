<?php

namespace App\Models\Trainings;

use App\Models\Core\City;
use App\Models\Core\Keyword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 * @method static pluck(string $string, string $string1)
 * @method static get()
 * @method static orderBy(string $string, string $string1)
 * @method static where(string $string, string $string1, $id)
 */
class Author extends Model{
    use HasFactory, SoftDeletes;

    protected $table = 'trainings__authors';
    protected $guarded = ['id'];

    public function typeRel(): HasOne{
        return $this->hasOne(Keyword::class, 'id', 'type');
    }
    public function getFullNameAttribute() : string{
        return ucwords($this->title . ' (' . ($this->typeRel->name ?? '') . ')');
    }
    public function cityRel(): HasOne{
        return $this->hasOne(City::class, 'id', 'city');
    }
}
