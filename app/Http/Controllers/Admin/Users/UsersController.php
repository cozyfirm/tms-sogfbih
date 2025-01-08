<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Core\Filters;
use App\Models\Core\Country;
use App\Models\Core\Keyword;
use App\Models\User;
use App\Traits\Http\ResponseTrait;
use App\Traits\Users\UserBaseTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UsersController extends Controller{
    use UserBaseTrait, ResponseTrait;
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
            'city' => __('Grad'),
            'countryRel->name_ba' => __('Država')
        ];

        return view($this->_path . 'index', [
            'filters' => $filters,
            'users' => $users
        ]);
    }
    public function create (): View{
        return view($this->_path . 'create', [
            'create' => true,
            'gender' => Keyword::getIt('gender')
            // 'countries' => Country::pluck('name_ba', 'id')
        ]);
    }
    public function save(Request $request): JsonResponse{
        try{
            $request['birth_date'] = Carbon::parse($request->birth_date)->format('Y-m-d');

            if (isset($request->email)) {
                $user = User::where('email', '=', $request->email)->first();

                if($user){
                    return $this->jsonError('1500', __('Odabrani email već postoji :D'));
                }
            }

            /* Add username to request */
            $request['username'] = $this->getSlug($request->name);

            /* Hash password and add token */
            $request['password'] = Hash::make(md5(time()));
            $request['api_token'] = hash('sha256', 'root'. '+'. time());
            if (isset($request->birth_date)) $request['birth_date'] = Carbon::parse($request->birth_date)->format('Y-m-d');

            /* Update user */
            $user = User::create($request->except(['id']));

            return $this->jsonSuccess(__('Uspješno ste ažurirali podatke!'), route('system.admin.users.preview', ['username' => $user->username]));
        }catch (\Exception $e){
            return $this->jsonError('1500', __('Greška prilikom procesiranja podataka. Molimo da nas kontaktirate!'));
        }
    }

    public function preview ($username): View{
        return view($this->_path . 'create', [
            'preview' => true,
            'user' => User::where('username', '=', $username)->first(),
            'gender' => Keyword::getIt('gender')
            // 'countries' => Country::pluck('name_ba', 'id')
        ]);
    }
    public function edit ($username): View{
        return view($this->_path . 'create', [
            'edit' => true,
            'user' => User::where('username', '=', $username)->first(),
            'gender' => Keyword::getIt('gender')
            // 'countries' => Country::pluck('name_ba', 'id')
        ]);
    }
    public function update(Request $request): JsonResponse{
        try{
            $request['birth_date'] = Carbon::parse($request->birth_date)->format('Y-m-d');

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
}
