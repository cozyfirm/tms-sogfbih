<?php

namespace App\Models\Other\InternalEvents;

use App\Models\Core\Keyword;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static orderBy(string $string, string $string1)
 * @method static create(array $except)
 * @method static where(string $string, string $string1, $id)
 */
class InternalEvent extends Model{
    use HasFactory, SoftDeletes;

    protected $table = 'internal__events';
    protected $guarded = ['id'];

    public function date(): string{
        return Carbon::parse($this->date)->format('d.m.Y');
    }

    public function projectRel(): HasOne{
        return $this->hasOne(Keyword::class, 'id', 'project');
    }
}
