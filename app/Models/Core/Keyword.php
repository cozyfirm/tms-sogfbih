<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $except)
 * @method static where(string $string, string $string1, $key)
 */
class Keyword extends Model{
    use HasFactory, SoftDeletes;

    protected $table = '__keywords';
    protected $guarded =  ['id'];

    protected static $_keywords = [
        /* Questions keywords */
        // 'yes_no' => 'Da / Ne',
        // 'gender' => 'Spol',
        // 'city_type' => 'Grad ili općina',
        'users__institutions' => 'Insitucija iz koje korisnik dolazi',
        'trainings__areas' => 'Šire oblasti programa obuke',
        'trainings__financed_by' => 'Finansijeri programa obuka',
        'trainings__projects' => 'Projekti u okviru kojih se izrađuju programi',
        'trainings__participants' => 'Učesnici programa',
        'user_type' => 'Fizička ili pravna lica',
        'event_type' => 'Vrsta događaja',
        'users__education_level' => 'Stepen stručne spreme',
        'trainers__areas' => 'Oblasti iz koje treneri dolaze',
        // 'trainer__grade' => 'Ocjena trenera',
        'evaluation__question_type' => 'Evaluacije: Vrsta pitanja',
//        'evaluation__type' => 'Evaluacije: Vrsta evaluacije',
        'evaluation__groups' => 'Evaluacije',
        'application_status' => 'Status prijave',

        /* Internal events */
        'ie__categories' => 'Kategorije (Interni događaji)',
        'ie__projects' => 'Projekti (Interni događaji)',

        /** Bodies */
        'bodies__category' => 'Kategorija (Organi i tijela)'
    ];

    /* Return all types of keywords */
    public static function getKeywords(): array { return self::$_keywords; }
    public static function getKeyword($key): string{ return self::$_keywords[$key]; }
    public static function getIt($key){ return Keyword::where('type', '=', $key)->orderBy('name')->pluck('name', 'id'); }
    public static function getItByVal($key){ return Keyword::where('type', '=', $key)->orderBy('name')->pluck('name', 'value'); }
    public static function getKeywordName($id){
        try{
            return Keyword::where('id', '=', $id)->first()->name;
        }catch (\Exception $e){ return ""; }
    }

    /**
     *  Keyword relationships
     */
}
