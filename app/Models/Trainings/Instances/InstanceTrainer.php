<?php

namespace App\Models\Trainings\Instances;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static create(array $array)
 * @method static where(string $string, string $string1, mixed $instance_id)
 */
class InstanceTrainer extends Model{
    use HasFactory;

    protected $table = 'trainings__instances_trainers';
    protected $guarded = ['id'];

    public function trainerRel(): HasOne{
        return $this->hasOne(User::class, 'id', 'trainer_id');
    }
}
