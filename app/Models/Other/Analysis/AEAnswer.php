<?php

namespace App\Models\Other\Analysis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AEAnswer extends Model{
    use HasFactory;

    protected $table = 'evaluations__analysis_answers';
    protected $guarded = ['id'];
}
