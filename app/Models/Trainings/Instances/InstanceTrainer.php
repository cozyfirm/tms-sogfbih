<?php

namespace App\Models\Trainings\Instances;

use App\Models\User;
use App\Traits\Common\CommonTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static create(array $array)
 * @method static where(string $string, string $string1, mixed $instance_id)
 */
class InstanceTrainer extends Model{
    use HasFactory, CommonTrait;

    protected $table = 'trainings__instances_trainers';
    protected $guarded = ['id'];

    public function trainerRel(): HasOne{
        return $this->hasOne(User::class, 'id', 'trainer_id');
    }
    public function instanceRel(): HasOne{
        return $this->hasOne(Instance::class, 'id', 'instance_id');
    }

    public function createdAt(): string{
        $createdAt = Carbon::parse($this->created_at);

        return $createdAt->format('d') . '. ' . $this->_months_short[((int)$createdAt->format('m')) - 1] . ' ' . $createdAt->format('Y H:i') . 'h';
    }
}
