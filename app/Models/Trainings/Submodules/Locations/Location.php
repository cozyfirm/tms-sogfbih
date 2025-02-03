<?php

namespace App\Models\Trainings\Submodules\Locations;

use App\Models\Core\City;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static orderBy(string $string)
 * @method static create(array $except)
 * @method static where(string $string, string $string1, $id)
 * @method static pluck(string $string, string $string1)
 */
class Location extends Model{
    use HasFactory, SoftDeletes;

    protected $table = '__locations';
    protected $guarded = ['id'];

    public function cityRel(): HasOne{
        return $this->hasOne(City::class, 'id', 'city');
    }
}
