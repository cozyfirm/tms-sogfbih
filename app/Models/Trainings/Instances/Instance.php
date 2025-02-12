<?php

namespace App\Models\Trainings\Instances;

use App\Models\Core\File;
use App\Models\Core\Keyword;
use App\Models\Trainings\Training;
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
 * @method static count()
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

    public function filesRel(): HasMany{
        return $this->hasMany(InstanceFile::class, 'instance_id', 'id');
    }
    public function trainersRel(): HasMany{
        return $this->hasMany(InstanceTrainer::class, 'instance_id', 'id');
    }
    public function eventsRel(): HasMany{
        return $this->hasMany(InstanceEvent::class, 'instance_id', 'id')->orderBy('tf__dt');
    }
    public function reportRel(): HasOne{
        return $this->hasOne(Keyword::class, 'value', 'report')->where('type', 'yes_no');
    }
    public function reportFileRel(): HasOne{
        return $this->hasOne(File::class, 'id', 'report_id');
    }
}
