<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static where(string $string, string $string1, int $int)
 * @method static create(array $except)
 * @method static orderBy(string $string)
 * @method static pluck(string $string, string $string1)
 */
class City extends Model{
    use HasFactory, SoftDeletes;

    protected $table = '__cities';
    protected $guarded = ['id'];

    public function countryRel(): HasOne{
        return $this->hasOne(Country::class, 'id', 'country_id');
    }
    public function typeRel(): HasOne{
        return $this->hasOne(Keyword::class, 'id', 'type')->where('type', 'city_type');
    }
}
