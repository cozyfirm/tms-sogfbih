<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Core\City;
use App\Models\Core\Country;
use App\Models\Core\Keyword;
use App\Models\Trainings\Instances\InstanceApp;
use App\Models\Trainings\Instances\InstanceTrainer;
use App\Models\Users\Education;
use App\Models\Users\Notification;
use App\Models\Users\SystemAccess;
use App\Traits\Common\CommonTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @method static where(string $string, string $string1, int $int)
 * @method static create(array $except)
 * @method static whereIn(string $string, string[] $array)
 * @method static pluck(string $string, string $string1)
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, CommonTrait;

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
        'image_id',
        'notifications'
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

    /**
     * Get initials of user; First letter of name and first letter of surname
     *
     * @return string
     */
    public function getInitials(): string{
        return mb_substr($this->first_name ?? '', 0, 1) . (isset($this->last_name) ? mb_substr($this->last_name ?? '', 0, 1) : '');
    }

    /**
     *  Get user role in bosnian language
     */
    public function getRole(): string{
        if($this->role == 'admin') return __('Administrator');
        else if($this->role == 'moderator') return __('Moderator');
        else if($this->role == 'trainer') return __('Trener');
        else if($this->role == 'user') return __('Korisnik');
    }
    public function isAdmin(): bool{
        return ($this->role == 'admin' or $this->role == 'moderator');
    }

    /** Notifications relationships and methods */
    /**
     * Take last 10 notifications using this relationship
     *
     * @return HasMany
     */
    public function notificationsRel(): HasMany{
        return $this->hasMany(Notification::class, 'user_id', 'id')->orderBy('id', 'DESC')->take(10);
    }

    /**
     *  User data relationships
     */
    public function isSigned($instanceID): bool{
        return InstanceApp::where('instance_id', '=', $instanceID)->where('user_id', '=', $this->id)->count() > 0;
    }
    public function appAvailable($instanceID): bool{
        $application = InstanceApp::where('instance_id', '=', $instanceID)->where('user_id', '=', $this->id)->first();
        if(!$application) return true;
        else{
            return ($application->status == 1);
        }
    }
    public function totalCertificates(){
        return InstanceApp::where('user_id', '=', $this->id)->whereNotNull('certificate_id')->count();
    }
    public function myCertificates(): HasMany{
        return $this->HasMany(InstanceApp::class, 'user_id', 'id')->whereNotNull('certificate_id')->orderBy('id', 'DESC');
    }
    public function appStatus($instanceID): string{
        $application = InstanceApp::where('instance_id', '=', $instanceID)->where('user_id', '=', $this->id)->first();
        if(!$application) return __('Status nepoznat');
        else{
            if($application->status == 1) return "Na čekanju";
            else if($application->status == 2) return "Prijava prihvaćena";
            else if($application->status == 3) return "Prijava odbijena";
        }
    }

    public function myLastTrainings(): HasMany{
        return $this->HasMany(InstanceApp::class, 'user_id', 'id')->take(10)->orderBy('id', 'DESC');
    }
    public function totalTrainings(): int{
        return InstanceApp::where('user_id', '=', $this->id)->where('status', '=', 2)->count();
    }
    public function genderRel(): HasOne{
        return $this->hasOne(Keyword::class, 'id', 'gender');
    }
    public function educationRel(): HasOne{
        return $this->hasOne(Education::class, 'user_id', 'id');
    }
    public function cityRel(): HasOne{
        return $this->hasOne(City::class, 'id', 'city');
    }
    public function institutionRel(): HasOne{
        return $this->hasOne(Keyword::class, 'id', 'institution');
    }
    public function systemAccessRel(): HasMany{
        return $this->hasMany(SystemAccess::class, 'user_id', 'id')->take(5)->orderBy('id', 'DESC');
    }

    /**
     *  User functions
     */
    public function userDaysOfTraining(): string{
        $applications = InstanceApp::where('user_id', '=', $this->id)->get();
        $totalDays = 0;
        foreach($applications as $application){
            try{
                $totalDays += $application->instanceRel->totalDays();
            }catch (\Exception $exception){}
        }

        return $totalDays;
    }

    /**
     *  Trainer relationships
     */
    public function trainersRel(): HasMany{
        return $this->hasMany(InstanceTrainer::class, 'trainer_id', 'id');
    }
    public function averageGrade(): string{
        return $this->roundNumber(InstanceTrainer::where('trainer_id', '=', $this->id)->where('grade', '!=', '0.0')->avg('grade'), 2);
    }
    public function contractValue(): string{
        return $this->roundNumber(InstanceTrainer::where('trainer_id', '=', $this->id)->where('grade', '!=', '0.0')->sum('contract'), 2);
    }
}
