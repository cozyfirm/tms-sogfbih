<?php

namespace App\Models\Trainigs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingFile extends Model{
    use HasFactory;

    protected $table = 'trainings__files';
    protected $guarded = ['id'];
}
