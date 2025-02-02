<?php

namespace App\Models\Trainigs\Instances;

use App\Models\Trainigs\Training;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static orderBy(string $string, string $string1)
 * @method static create(array $except)
 * @method static where(string $string, string $string1, $id)
 */
class Instance extends Model{
    use HasFactory, SoftDeletes;

    protected $table = 'trainings__instances';
    protected $guarded = ['id'];

    public function applicationDate(): string{
        return Carbon::parse($this->application_date)->format('d.m.Y');
    }

    /**
     *  Helper methods:
     *      1. Start date of training
     *      2. End date of training
     */
    public function startDate(): string{
        return Carbon::parse($this->application_date)->format('d.m.Y');
    }
    public function endDate(): string{
        return Carbon::parse($this->application_date)->addDays(4)->format('d.m.Y');
    }

    public function trainingRel(): HasOne{
        return $this->hasOne(Training::class, 'id', 'training_id');
    }
    public function lunchesRel(): HasMany{
        return $this->hasMany(InstanceLunch::class, 'instance_id', 'id');
    }

    public function datesRel(): HasMany{
        return $this->hasMany(InstanceDate::class, 'instance_id', 'id');
    }
}
