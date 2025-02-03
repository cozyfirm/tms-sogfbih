<?php

namespace App\Models\Trainings\Submodules\Locations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static orderBy(string $string)
 * @method static create(array $except)
 * @method static where(string $string, string $string1, $id)
 */
class Location extends Model{
    use HasFactory, SoftDeletes;

    protected $table = '__locations';
    protected $guarded = ['id'];
}
