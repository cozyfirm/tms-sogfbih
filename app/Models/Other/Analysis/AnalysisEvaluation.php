<?php

namespace App\Models\Other\Analysis;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AnalysisEvaluation extends Model{
    use HasFactory;

    protected $table = 'evaluations__analysis';
    protected $guarded = ['id'];

    public function userRel(): HasOne{
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
