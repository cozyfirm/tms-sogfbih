<?php

namespace App\Models\Other\Bodies;

use App\Models\Core\Keyword;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static orderBy(string $string, string $string1)
 * @method static create(array $except)
 * @method static where(string $string, string $string1, $id)
 */
class Bodies extends Model{
    use HasFactory, SoftDeletes;

    protected $table = 'bodies';
    protected $guarded = ['id'];

    public function date(): string{
        return Carbon::parse($this->date)->format('d.m.Y');
    }
}
