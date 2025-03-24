<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Core\Filters;
use App\Mail\Users\Welcome;
use App\Models\Core\City;
use App\Models\Core\Country;
use App\Models\Core\Keyword;
use App\Models\User;
use App\Models\Users\Education;
use App\Traits\Common\CommonTrait;
use App\Traits\Http\ResponseTrait;
use App\Traits\Users\UserBaseTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class UsersController extends Controller{
    use UserBaseTrait, ResponseTrait, CommonTrait;
    protected string $_path = 'admin.app.users.';

    public function index(): View{
        $users = User::where('id', '>', 0);
        $users = Filters::filter($users);

        $filters = [
            'name' => __('Ime i prezime'),
            'email' => 'Email',
            'role' => __('Uloga'),
            'phone' => __('Telefon'),
            'birth_date' => __('Datum rođenja'),
            'address' => __('Adresa'),
            'cityRel.title' => __('Grad'),
            'cityRel.countryRel.name_ba' => __('Država')
        ];

        return view($this->_path . 'index', [
            'filters' => $filters,
            'users' => $users
        ]);
    }
    public function create (): View{
        return view($this->_path . 'create', [
            'create' => true,
            'gender' => Keyword::getIt('gender'),
            'institutions' => Keyword::getIt('users__institutions')->prepend('Odaberite instituciju', ''),
            'cities' => City::pluck('title', 'id')->prepend('Odaberite grad', '')
        ]);
    }
    public function save(Request $request): JsonResponse{
        try{
            $request['birth_date'] = Carbon::parse($request->birth_date)->format('Y-m-d');
            $request['name'] = $request->first_name . ' ' . $request->last_name;

            if (isset($request->email)) {
                $user = User::where('email', '=', $request->email)->first();

                if($user){
                    return $this->jsonError('1500', __('Odabrani email već postoji!! '));
                }
            }

            /* Add username to request */
            $request['username'] = $this->getSlug($request->name);

            /* Hash password and add token */
            $request['password'] = $this->randomString(8);
            $request['api_token'] = hash('sha256', 'root'. '+'. time());
            if (isset($request->birth_date)) $request['birth_date'] = Carbon::parse($request->birth_date)->format('Y-m-d');

            /* Set profile as verified */
            $request['email_verified_at'] = Carbon::now();
            $request['role'] = 'user';

            /* Update user */
            $user = User::create($request->except(['id']));

            /** ToDo:: Send email to user with access data */

            $message = "Welcome email to " . ($user->name);
            try{
                Mail::to($user->email)->send(new Welcome($user->email, $user->name, $request->password, $user->gender));

                $message .= " is successfully sent!";
            }catch (\Exception $e){
                $message .= " was not sent! Error: " . $e->getMessage();
            }
            Log::info($message);

            return $this->jsonSuccess(__('Uspješno ste ažurirali podatke!'), route('system.admin.users.preview', ['username' => $user->username]));
        }catch (\Exception $e){
            return $this->jsonError('1500', __('Greška prilikom procesiranja podataka. Molimo da nas kontaktirate!'));
        }
    }

    public function preview ($username): View{
        return view($this->_path . 'preview', [
            'preview' => true,
            'user' => User::where('username', '=', $username)->first(),
            'gender' => Keyword::getIt('gender'),
            'institutions' => Keyword::getIt('users__institutions')->prepend('Odaberite instituciju', ''),
            'cities' => City::pluck('title', 'id')->prepend('Odaberite grad', '')
        ]);
    }
    public function edit ($username): View{
        return view($this->_path . 'create', [
            'edit' => true,
            'user' => User::where('username', '=', $username)->first(),
            'gender' => Keyword::getIt('gender'),
            'institutions' => Keyword::getIt('users__institutions')->prepend('Odaberite instituciju', ''),
            'cities' => City::pluck('title', 'id')->prepend('Odaberite grad', '')
        ]);
    }
    public function update(Request $request): JsonResponse{
        try{
            $request['birth_date'] = Carbon::parse($request->birth_date)->format('Y-m-d');
            $request['name'] = $request->first_name . ' ' . $request->last_name;

            if (isset($request->id)) {
                $user = User::where('id', '=', $request->id)->first();

                /* Update user */
                $user->update($request->except(['id']));
            }

            return $this->jsonSuccess(__('Uspješno ste ažurirali podatke!'), route('system.admin.users.preview', ['username' => $user->username]));
        }catch (\Exception $e){
            return $this->jsonError('1500', __('Greška prilikom procesiranja podataka. Molimo da nas kontaktirate!'));
        }
    }

    public function updateProfileImage (Request $request): RedirectResponse{
        try{
            $file = $request->file('photo_uri');
            $ext = pathinfo($file->getClientOriginalName(),PATHINFO_EXTENSION);
            $name = md5($file->getClientOriginalName().time()).'.'.$ext;
            $file->move(public_path('files/images/public-part/users'), $name);

            /* Update file name */
            User::where('id', '=', $request->id)->update(['photo_uri' => $name]);

        }catch (\Exception $e){}

        return back();
    }


    /* -------------------------------------------------------------------------------------------------------------- */
    /**
     * Education routes
     */


    public function editEducation ($username): View{
        $user = User::where('username', '=', $username)->first();

        return view($this->_path . 'education', [
            'edit' => true,
            'user' => $user,
            'educationLevels' => Keyword::getIt('users__education_level'),
            'education' => Education::where('user_id', '=', $user->id)->first()
        ]);
    }

    public function updateEducation(Request $request): JsonResponse{
        try{
            $request['graduation_date'] = Carbon::parse($request->graduation_date)->format('Y-m-d');

            $user = User::where('id', '=', $request->id)->first();
            $education = Education::where('user_id', '=', $request->id)->first();

            if($education){
                $education->update([
                    'level' => $request->level,
                    'school' => $request->school,
                    'university' => $request->university,
                    'title' => $request->title,
                    'graduation_date' => $request->graduation_date
                ]);
            }else{
                Education::create([
                    'user_id' => $request->id,
                    'level' => $request->level,
                    'school' => $request->school,
                    'university' => $request->university,
                    'title' => $request->title,
                    'graduation_date' => $request->graduation_date
                ]);
            }

            return $this->jsonSuccess(__('Uspješno ste ažurirali podatke!'), route('system.admin.users.preview', ['username' => $user->username]));
        }catch (\Exception $e){
            return $this->jsonError('1500', __('Greška prilikom procesiranja podataka. Molimo da nas kontaktirate!'));
        }
    }
}
