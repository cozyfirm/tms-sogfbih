<?php

namespace App\Models\Other\InternalEvents;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static create(array $array)
 * @method static where(string $string, string $string1, $id)
 */
class IEFiles extends Model{
    use HasFactory;

    protected $table = 'internal__events__files';
    protected $guarded = ['id'];

    public function ieREl(): HasOne{
        return $this->hasOne(InternalEvent::class, 'id', 'event_id');
    }
}
