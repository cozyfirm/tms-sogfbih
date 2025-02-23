<?php

namespace App\Models\Trainings;

use App\Models\Core\Keyword;
use App\Models\Trainings\Instances\Instance;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static orderBy(string $string, string $string1)
 * @method static count()
 * @method static create(array $except)
 * @method static where(string $string, string $string1, mixed $id)
 * @method static pluck(string $string, string $string1)
 */
class Training extends Model{
    use HasFactory;

    protected $guarded = ['id'];

    public function financedByRel(): HasOne{
        return $this->hasOne(Keyword::class, 'id', 'financed_by');
    }
    public function projectRel(): HasOne{
        return $this->hasOne(Keyword::class, 'id', 'project');
    }
    public function areasRel(): HasMany{
        return $this->hasMany(TrainingArea::class, 'training_id', 'id');
    }
    public function participantsRel(): HasMany{
        return $this->hasMany(TrainingParticipant::class, 'training_id', 'id');
    }
    public function authorsRel(): HasMany{
        return $this->hasMany(AuthorRel::class, 'training_id', 'id');
    }
    public function filesRel(): HasMany{
        return $this->hasMany(TrainingFile::class,'training_id', 'id');
    }

    /**
     *  Instance relationships
     */
    public function instancesRel(): HasMany{
        return $this->hasMany(Instance::class, 'training_id', 'id');
    }
}
