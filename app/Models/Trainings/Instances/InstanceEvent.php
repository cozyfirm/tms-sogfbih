<?php

namespace App\Models\Trainings\Instances;

use App\Models\Core\Keyword;
use App\Models\Trainings\Submodules\Locations\Location;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static where(string $string, string $string1, mixed $instance_id)
 * @method static create(array $except)
 */
class InstanceEvent extends Model{
    use HasFactory, SoftDeletes;

    protected $table = 'trainings__instances_events';
    protected $guarded = ['id'];

    public function date(): string{
        return Carbon::parse($this->date)->format('d.m.Y');
    }

    public function typeRel(): HasOne{
        return $this->hasOne(Keyword::class, 'value', 'type')->where('type', 'event_type');
    }
    public function instanceRel(): HasOne{
        return $this->hasOne(Instance::class, 'id', 'instance_id');
    }
    public function locationRel(): HasOne{
        return $this->hasOne(Location::class, 'id', 'location_id');
    }
}
