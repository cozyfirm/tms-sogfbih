<?php

namespace App\Models\Other;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 * @method static where(string $string, string $string1, mixed $instance_id)
 */
class Participant extends Model{
    use HasFactory, SoftDeletes;

    protected $table = 'other__participants';
    protected $guarded = ['id'];
}
