<?php

namespace App\Models\Other\InternalEvents;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IEFiles extends Model{
    use HasFactory;

    protected $table = 'internal__events__files';
    protected $guarded = ['id'];
}
