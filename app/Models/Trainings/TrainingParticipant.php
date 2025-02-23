<?php

namespace App\Models\Trainings;

use App\Models\Core\Keyword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TrainingParticipant extends Model{
    use HasFactory;
    protected $table = 'trainings__participants';
    protected $guarded = ['id'];

    public function participantRel(): HasOne{
        return $this->hasOne(Keyword::class, 'id', 'participant_id');
    }
}
