<?php

namespace App\Models\Trainigs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model{
    use HasFactory;

    protected $table = 'trainings__authors';
    protected $guarded = ['id'];


}
