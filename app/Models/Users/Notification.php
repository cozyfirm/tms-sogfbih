<?php

namespace App\Models\Users;

use App\Models\User;
use App\Traits\Common\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $array)
 */
class Notification extends Model{
    use HasFactory, SoftDeletes, CommonTrait;

    protected $table = '__notifications';
    protected $guarded = ['id'];

    public function createdAt(): string{
        return $this->date($this->created_at);
    }
    public function userRel(): HasOne{
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function fromRel(): HasOne{
        return $this->hasOne(User::class, 'id', 'from');
    }
}
