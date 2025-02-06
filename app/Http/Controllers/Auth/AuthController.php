<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\Users\RestartPassword;
use App\Models\Core\City;
use App\Models\Core\Country;
use App\Models\Core\Keyword;
use App\Models\Users\Education;
use App\Models\Users\RestartToken;
use App\Models\User;
use App\Traits\Http\ResponseTrait;
use App\Traits\Users\UserBaseTrait;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AuthController extends Controller{
    use UserBaseTrait, ResponseTrait;
    protected string $_path = 'public-part.auth.';

    /**
     *  Return Auth view
     */
    public function auth(){
        return view($this->_path. 'auth');
    }

    public function authenticate(Request $request): bool|string{
        if(empty($request->email)) return json_encode(['code' => '1101', 'message' => __('Molimo da unesete Vaš email') ]);
        if(empty($request->password)) return json_encode(['code' => '1102', 'message' => __('Molimo da unesete Vašu šifru') ]);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();

            if($user->email_verified_at == null){
                Auth::logout();
                return json_encode([
                    'code' => '1102',
                    'message' => __('Molimo Vas da verifikujete Vaš račun!!')
                ]);
            }

            $uri = route('system.home');
            if($user->role == 'user') $uri = route('dashboard.welcome');

            return json_encode([
                'code' => '0000',
                'message' => __('Uspješno ste se prijavili!'),
                'url' => $uri
            ]);

//            if(!($user->active ?? '')){
//                return json_encode(array('code' => '0001', 'message' => __('Pristup za korisnika '. ($user->name ?? '') .' nije dozvoljen!')));
//            }else{
//                return json_encode([
//                    'code' => '0000',
//                    'message' => __('Uspješno ste se prijavili!'),
//                    'url' => route('system.users.profile')
//                ]);
//            }
        }else {
            return json_encode([
                'code' => '1100',
                'message' => __('Pogrešni pristupni podaci. Molimo pokušajte ponovo!')
            ]);
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * Destroy sessions and log user out
     */
    public function logout(): \Illuminate\Http\RedirectResponse{
        Auth::logout();
        return redirect()->route('auth');
    }

    /* -------------------------------------------------------------------------------------------------------------- */
    /*
     *  Register Form
     */

    /**
     *  Return view for account creation
     */
    public function createAccount(): View{
        return view($this->_path. 'create-account', [
            // 'prefixes' => Country::orderBy('phone_code')->get()->pluck('phone_code', 'id'),
            // 'countries' => Country::orderBy('name_ba')->get()->pluck('name_ba', 'id'),
            'educationLevels' => Keyword::getIt('users__education_level'),
            'cities' => City::pluck('title', 'id')
        ]);
    }

    /**
     * @param Request $request
     * @return bool|\Illuminate\Http\JsonResponse|string|void
     *
     * Ajax END-Point; Create new profile
     */
    public function saveAccount(Request $request){
        try{
            /* Password cannot be empty */
            if(!isset($request->password)) return $this->jsonResponse('1001', __('Unesite Vašu šifru'));
            if(!isset($request->first_name) || !isset($request->last_name)) return;

            /* Check for unique email */
            $user = User::where('email', '=', $request->email)->first();
            if($user) return $this->jsonResponse('1002', __('Odabrani email se već koristi'));

            /* Add username to request */
            $request['name'] = $request->first_name . ' ' . $request->last_name;
            $request['username'] = $this->getSlug($request->name);

            /* Hash password and add token */
            $request['password'] = Hash::make($request->password);
            $request['api_token'] = hash('sha256', $request->email. '+'. time());
            $request['birth_date'] = Carbon::parse($request->birth_date)->format('Y-m-d');

            /* When user is created, UserObserver is called and email was sent */
            /* Note: Data is logged into laravel.log */
            $user = User::create($request->all());

            /**
             *  Now, create education
             */
            $graduationDate = isset($request->ue_graduation_date) ? Carbon::parse($request->ue_graduation_date)->format('Y-m-d') : null;

            Education::create([
                'user_id' => $user->id,
                'level' => $request->ue_level,
                'title' => $request->ue_title,
                'school' => $request->ue_school,
                'university' => $request->ue_university,
                'graduation_date' => $graduationDate
            ]);

            if($user) return $this->jsonSuccess(__('Uspješno ste se kreirali korisnički račun!'), route('auth'));
        }catch (\Exception $e){
            return $this->jsonResponse('1101', __('Greška prilikom procesiranja podataka. Molimo da nas kontaktirate!'));
        }
    }
    public function verifyAccount($token): RedirectResponse{
        try{
            $user = User::where('api_token', '=', $token)->first();
            $user->update(['email_verified_at' => Carbon::now()]);
            Auth::login($user);
        }catch (\Exception $e){ }

        return redirect()->route('public.home');
    }

    /* -------------------------------------------------------------------------------------------------------------- */
    /*
     *  Restart password methods
     */

    /**
     * @return \Illuminate\Contracts\Foundation\Application
     */
    public function restartPassword(){
        return view($this->_path. 'restart-password');
    }

    /**
     * @param Request $request
     * @return bool|string|void
     * Post method to generate new restart_password token
     */
    public function generateRestartToken(Request $request){
        try{
            /* Delete previous tokens */
            RestartToken::where('email', $request->email)->delete();


            $token = RestartToken::create(['email' => $request->email, 'token' => md5(time())]);
            $user  = User::where('email', $request->email)->first();

            /* Set email with instructions */
            Mail::to($request->email)->send(new RestartPassword($user->email, $token->token));

            return $this->jsonSuccess(__('Detaljne upute su Vam poslane putem email-a!'));
        }catch (\Exception $e){
            return $this->jsonResponse('1131', __('Greška prilikom procesiranja podataka. Molimo da nas kontaktirate!'));
        }
    }

    /**
     * @param $token
     * @return \Illuminate\Contracts\Foundation\Application
     *
     * Offer user option to insert new password
     */
    public function newPassword($token){
        return view($this->_path. 'new-password', [
            'token' => $token
        ]);
    }

    public function generateNewPassword(Request $request){
        try{
            if(!isset($request->email)) return $this->jsonResponse('1142', __('Molimo da unesete Vaš email'));
            if(!isset($request->password)) return $this->jsonResponse('11413', __('Unesite Vašu šifru'));
            if(!isset($request->repeat)) return $this->jsonResponse('11414', __('Potvrdite Vašu šifru'));

            if($request->password != $request->repeat) return $this->jsonResponse('11415', __('Unesene šifre se ne podudaraju!'));

            /* Get sample from DB */
            $token = RestartToken::where('email', $request->email)->where('token', $request->token)->first();

            /* Check if token is valid */
            if(!$token) return $this->jsonResponse('11416', __('Token nije važeći!'), ['url' => route('auth')]);

            /* Update user password */
            User::where('email', $request->email)->update([
                'password' => Hash::make($request->password)
            ]);

            /* Remove token from DB; Query Again since there is no PK */
            RestartToken::where('email', $request->email)->delete();

            return json_encode([
                'code' => '0000',
                'message' => __('Korisnička šifra uspješno izmijenjena!'),
                'url' => route('auth')
            ]);
        }catch (\Exception $e){
            return json_encode([
                'code' => '1141',
                'message' => __('Greška prilikom procesiranja podataka. Molimo da nas kontaktirate!')
            ]);
        }
    }
}
