<?php

namespace App\Models\Trainings\Instances;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $except)
 */
class InstanceDate extends Model{
    use HasFactory, SoftDeletes;

    protected $table = 'trainings__instances_dates';
    protected $guarded = ['id'];

    public function date(): string{
        return Carbon::parse($this->date)->format('d.m.Y');
    }
}
