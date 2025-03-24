<?php

namespace App\Models\Users;

use App\Traits\Common\CommonTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class SystemAccess extends Model{
    use HasFactory, CommonTrait;

    protected $table = 'users__system_access';
    protected $guarded = ['id'];

    public function dateTime(): string{
        return $this->date($this->created_at);
    }
}
