<?php

namespace App\Models\Trainigs\Instances;

use App\Models\Core\File;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static create(array $array)
 */
class InstanceFile extends Model{
    use HasFactory;

    protected $table = 'trainings__instances_files';
    protected $guarded = ['id'];

    public function fileRel(): HasOne{
        return $this->hasOne(File::class, 'id', 'file_id');
    }
    public function instanceRel(): HasOne{
        return $this->hasOne(Instance::class, 'id', 'instance_id');
    }
    public function userRel(): HasOne{
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
