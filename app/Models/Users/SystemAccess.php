<?php

namespace App\Models\Users;

use App\Models\User;
use App\Traits\Common\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static create(array $array)
 * @method static orderBy(string $string, string $string1)
 */
class SystemAccess extends Model{
    use HasFactory, CommonTrait;

    protected $table = 'users__system_access';
    protected $guarded = ['id'];

    public function dateTime(): string{
        return $this->date($this->created_at);
    }
    public function userRel(): HasOne{
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
