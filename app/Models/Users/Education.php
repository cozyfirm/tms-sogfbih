<?php

namespace App\Models\Users;

use App\Models\Core\Keyword;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 * @method static where(string $string, string $string1, $id)
 */
class Education extends Model{
    use HasFactory, SoftDeletes;

    protected $table = 'users__education';
    protected $guarded = ['id'];

    public function date(){
        return Carbon::parse($this->graduation_date)->format('d.m.Y');
    }

    public function levelRel(): HasOne{
        return $this->hasOne(Keyword::class, 'id', 'level');
    }
}
