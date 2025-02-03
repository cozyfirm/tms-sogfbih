<?php

namespace App\Models\Trainings\Instances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $except)
 */
class InstanceLunch extends Model{
    use HasFactory, SoftDeletes;

    protected $table = 'trainings__instances_lunches';
    protected $guarded = ['id'];

}
