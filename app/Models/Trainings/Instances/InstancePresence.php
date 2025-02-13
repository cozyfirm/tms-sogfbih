<?php

namespace App\Models\Trainings\Instances;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static create(array $array)
 * @method static where(string $string, string $string1, mixed $id)
 */
class InstancePresence extends Model{
    use HasFactory;

    protected $table = 'trainings__instances_presence';
    protected $guarded = ['id'];

    public function appRel(): HasOne{
        return $this->hasOne(InstanceApp::class, 'id', 'application_id');
    }
}
