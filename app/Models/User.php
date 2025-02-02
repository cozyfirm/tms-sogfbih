<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Core\Country;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @method static where(string $string, string $string1, int $int)
 * @method static create(array $except)
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'username',
        'email',
        'email_verified_at',
        'password',
        'api_token',
        'role',
        'access',
        'phone',
        'birth_date',
        'gender',
        'address',
        'city',
        'workplace',
        'institution',
        'comment',
        'image_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function photoUri(){
        return isset($this->photo_uri) ? $this->photo_uri : 'silhouette.png';
    }
    public function birthDate(): string {
        return Carbon::parse(isset($this->birth_date) ? $this->birth_date : date('Y-m-d'))->format('d.m.Y');
    }
    public function countryRel(): HasOne{
        return $this->hasOne(Country::class, 'id', 'country');
    }
    public function getInitials(): string{
        return substr($this->first_name ?? '', 0, 1) . (isset($this->last_name) ? substr($this->last_name ?? '', 0, 1) : '');
    }
}
