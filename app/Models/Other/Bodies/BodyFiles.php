<?php

namespace App\Models\Other\Bodies;

use App\Models\Other\InternalEvents\InternalEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static create(array $array)
 */
class BodyFiles extends Model{
    use HasFactory;

    protected $table = 'bodies__files';
    protected $guarded = ['id'];

    public function bodyRel(): HasOne{
        return $this->hasOne(Bodies::class, 'id', 'body_id');
    }
}
