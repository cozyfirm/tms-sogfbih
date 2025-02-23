<?php

namespace App\Models\Trainings\Instances;

use App\Models\Core\Keyword;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static where(string $string, string $string1, mixed $instanceID)
 */
class InstanceApp extends Model{
    use HasFactory;

    protected $table = 'trainings__instances_applications';
    protected $guarded = ['id'];

    public function date(): string{
        return Carbon::parse($this->date)->format('d.m.Y');
    }
    public function instanceRel(): HasOne{
        return $this->hasOne(Instance::class, 'id', 'instance_id');
    }
    public function userRel(): HasOne{
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function statusRel(): HasOne{
        return $this->hasOne(Keyword::class, 'value', 'status')->where('type', 'application_status');
    }
}
