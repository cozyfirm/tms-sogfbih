<?php

namespace App\Http\Controllers\UserData;

use App\Http\Controllers\Controller;
use App\Models\Core\City;
use App\Models\Core\Keyword;
use App\Models\User;
use App\Models\Users\Education;
use App\Traits\Http\ResponseTrait;
use App\Traits\Users\UserBaseTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MyProfileController extends Controller{
    use UserBaseTrait, ResponseTrait;

    protected string $_path = 'user-data.profile.';

    public function myProfile(): View{
        return view($this->_path . 'my-profile', [
            'preview' => true,
            'user' => Auth::user(),
            'gender' => Keyword::getIt('gender'),
            'institutions' => Keyword::getIt('users__institutions')->prepend('Odaberite instituciju', ''),
            'cities' => City::pluck('title', 'id')
        ]);
    }
    public function edit(): View{
        return view($this->_path . 'my-profile', [
            'edit' => true,
            'user' => Auth::user(),
            'gender' => Keyword::getIt('gender'),
            'institutions' => Keyword::getIt('users__institutions')->prepend('Odaberite instituciju', ''),
            'cities' => City::pluck('title', 'id')
        ]);
    }

    public function update(Request $request): JsonResponse{
        try{
            $request['birth_date'] = Carbon::parse($request->birth_date)->format('Y-m-d');
            $request['name'] = $request->first_name . ' ' . $request->last_name;
            Auth::user()->update($request->all());

            return $this->jsonSuccess(__('Uspješno ažurirano!'), route('system.user-data.my-profile'));
        }catch (\Exception $e){
            return $this->jsonError('3000', __('Greška prilikom procesiranja podataka. Molimo da nas kontaktirate!'));
        }
    }

    /** ------------------------------------------------------------------------------------------------------------- */
    /**
     *  Education info
     */
    public function education(): View{
        return view($this->_path . 'education', [
            'user' => Auth::user(),
            'educationLevels' => Keyword::getIt('users__education_level'),
            'education' => Education::where('user_id', '=', Auth::user()->id)->first()
        ]);
    }
    public function educationUpdate(Request $request): JsonResponse{
        try{
            $request['graduation_date'] = Carbon::parse($request->graduation_date)->format('Y-m-d');

            Education::where('user_id', '=', Auth::user()->id)->update($request->all());

            return $this->jsonSuccess(__('Uspješno ažurirano!'), route('system.user-data.my-profile'));
        }catch (\Exception $e){
            return $this->jsonError('3000', __('Greška prilikom procesiranja podataka. Molimo da nas kontaktirate!'));
        }
    }
}
