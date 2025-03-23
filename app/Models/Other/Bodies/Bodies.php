<?php

namespace App\Models\Other\Bodies;

use App\Models\Core\Keyword;
use App\Models\Other\Participant;
use App\Models\Trainings\Submodules\Locations\Location;
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
 */
class Bodies extends Model{
    use HasFactory, SoftDeletes;

    protected $table = 'bodies';
    protected $guarded = ['id'];

    public function date(): string{
        return Carbon::parse($this->date)->format('d.m.Y');
    }

    public function categoryRel(): HasOne{
        return $this->hasOne(Keyword::class, 'id', 'category');
    }
    public function locationRel(): HasOne{
        return $this->hasOne(Location::class, 'id', 'location_id');
    }
    public function participantsRel(): HasMany{
        return $this->hasMany(Participant::class, 'model_id', 'id')->where('type', 'bodies')->orderBy('name');
    }
}
