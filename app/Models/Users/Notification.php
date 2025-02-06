<?php

namespace App\Models\Users;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 */
class Notification extends Model{
    use HasFactory, SoftDeletes;

    protected $table = '__notifications';
    protected $guarded = ['id'];

    public function userRel(): HasOne{
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function fromRel(): HasOne{
        return $this->hasOne(User::class, 'id', 'from');
    }
}
