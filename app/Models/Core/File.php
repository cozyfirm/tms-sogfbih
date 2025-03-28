<?php

namespace App\Models\Core;

use App\Models\Other\Bodies\BodyFiles;
use App\Models\Other\InternalEvents\IEFiles;
use App\Models\Trainings\Instances\InstanceFile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property string $file
 * @property string $name
 * @property string $ext
 * @property string $type
 * @property string $path
 * @method static where(string $string, string $string1, $file_id)
 * @method static whereHas(string $string, \Closure $param)
 */
class File extends Model{
    use HasFactory;

    protected $table = '__files';
    protected $guarded = ['id'];

    public function getFile(): string {
        return "/{$this->path}/{$this->name}";
    }

    /**
     *  Relationship models
     */
    public function createdBy(): HasOne{
        return $this->hasOne(User::class, 'id', 'created_by');
    }
    public function instanceRel(): HasOne{
        return $this->hasOne(InstanceFile::class, 'file_id', 'id');
    }
    public function ieRel(): HasOne{
        return $this->hasOne(IEFiles::class, 'file_id', 'id');
    }
    public function bodyRel(): HasOne{
        return $this->hasOne(BodyFiles::class, 'file_id', 'id');
    }
}
