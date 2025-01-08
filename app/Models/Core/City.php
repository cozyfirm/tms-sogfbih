<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static where(string $string, string $string1, int $int)
 */
class City extends Model{
    use HasFactory, SoftDeletes;

    protected $table = '__cities';
    protected $guarded = ['id'];
}
