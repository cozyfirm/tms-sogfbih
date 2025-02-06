<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 */
class Education extends Model{
    use HasFactory, SoftDeletes;

    protected $table = 'users__education';
    protected $guarded = ['id'];
}
