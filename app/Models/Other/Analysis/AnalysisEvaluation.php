<?php

namespace App\Models\Other\Analysis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalysisEvaluation extends Model{
    use HasFactory;

    protected $table = 'evaluations__analysis';
    protected $guarded = ['id'];
}
