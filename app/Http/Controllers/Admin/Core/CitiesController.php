<?php

namespace App\Http\Controllers\Admin\Core;

use App\Http\Controllers\Controller;
use App\Models\Core\City;
use App\Models\Core\Country;
use App\Models\Core\Keyword;
use App\Traits\Http\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CitiesController extends Controller{
    use ResponseTrait;

    protected string $_path = 'admin.app.core.cities.';

    public function index(): View{
        $cities = City::orderBy('title');
        $cities = Filters::filter($cities);

        $filters = [
            'title' => 'Naziv',
            'typeRel.name' => __('Vrsta'),
            'countryRel.name_ba' => __('Država')
        ];

        return view($this->_path . 'index', [
            'filters' => $filters,
            'cities' => $cities
        ]);
    }
    public function create(): View{
        return view($this->_path . 'create', [
            'create' => true,
            'types' => Keyword::getIt('city_type'),
            'countries' => Country::pluck('name_ba', 'id')
        ]);
    }
    public function save(Request $request): JsonResponse{
        try{
            $city = City::where('country_id', '=', $request->country_id)->where('title', '=', $request->title)->first();
            if($city){
                return $this->jsonError('1001', __('Već postoji grad sa tim nazivom!'));
            }

            $city = City::create($request->except(['_token']));

            return $this->jsonSuccess(__('Uspješno spašeno'), route('system.admin.core.settings.cities.preview', ['id' => $city->id ]));
        }catch (\Exception $e){
            return $this->jsonError('1000', __('Greška prilikom obrade podataka. Molimo kontaktirajte administratora!'));
        }
    }
    public function preview($id): View{
        return view($this->_path . 'create', [
            'preview' => true,
            'types' => Keyword::getIt('city_type'),
            'countries' => Country::pluck('name_ba', 'id'),
            'city' => City::where('id', '=', $id)->first()
        ]);
    }
    public function edit($id): View{
        return view($this->_path . 'create', [
            'edit' => true,
            'types' => Keyword::getIt('city_type'),
            'countries' => Country::pluck('name_ba', 'id'),
            'city' => City::where('id', '=', $id)->first()
        ]);
    }
    public function update(Request $request): JsonResponse{
        try{
            $city = City::where('country_id', '=', $request->country_id)->where('title', '=', $request->title)
                ->where('id', '!=', $request->id)->first();
            if($city){
                return $this->jsonError('1001', __('Već postoji grad sa tim nazivom!'));
            }

            $city = City::where('id', '=', $request->id)->update($request->except(['_token', 'id']));

            return $this->jsonSuccess(__('Uspješno spašeno'), route('system.admin.core.settings.cities.preview', ['id' => $request->id ]));
        }catch (\Exception $e){
            return $this->jsonError('1000', __('Greška prilikom obrade podataka. Molimo kontaktirajte administratora!'));
        }
    }
    public function delete($id): RedirectResponse{
        try{
            City::where('id', '=', $id)->delete();
        }catch (\Exception $e){
            return redirect()->route('system.admin.core.settings.cities.preview', ['id' => $id ]);
        }
        return redirect()->route('system.admin.core.settings.cities');
    }
}
