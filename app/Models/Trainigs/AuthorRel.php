<?php

namespace App\Models\Trainigs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AuthorRel extends Model{
    use HasFactory;

    protected $table = 'trainings__authors__rel';
    protected $guarded = ['id'];

    public function authorRel(): HasOne{
        return $this->hasOne(Author::class, 'id', 'author_id');
    }
}
