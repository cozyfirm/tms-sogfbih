<?php

namespace App\Models\Trainings\Instances;

use App\Models\Core\File;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static create(array $array)
 * @method static where(string $string, string $string1, $id)
 */
class InstanceFile extends Model{
    use HasFactory;

    protected $table = 'trainings__instances_files';
    protected $guarded = ['id'];

    public function visibility(): string{
        if(isset($this->visibility)) return ($this->visibility == 'public') ? __('Javno') : __('Privatno');
        else return __('Nije poznato');
    }
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
