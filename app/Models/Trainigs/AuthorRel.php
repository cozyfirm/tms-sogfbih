<?php

namespace App\Models\Trainigs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorRel extends Model{
    use HasFactory;

    protected $table = 'trainings__authors__rel';
    protected $guarded = ['id'];
}
