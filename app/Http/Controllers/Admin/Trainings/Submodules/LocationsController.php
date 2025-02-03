<?php

namespace App\Http\Controllers\Admin\Trainings\Submodules;

use App\Http\Controllers\Admin\Core\Filters;
use App\Http\Controllers\Controller;
use App\Models\Core\City;
use App\Models\Core\Country;
use App\Models\Core\Keyword;
use App\Models\Trainings\Submodules\Locations\Location;
use App\Traits\Common\CommonTrait;
use App\Traits\Common\FileTrait;
use App\Traits\Http\ResponseTrait;
use App\Traits\Trainings\TrainingTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LocationsController extends Controller{
    use ResponseTrait, CommonTrait, TrainingTrait, FileTrait;

    protected string $_path = 'admin.app.trainings.submodules.locations.';

    public function index(): View{
        $locations = Location::orderBy('title');
        $locations = Filters::filter($locations);

        $filters = [
            'title' => 'Naziv',
            'address' => __('Adresa'),
            'cityRel.title' => __('Grad'),
            'phone' => __('Broj telefona'),
            'email' => __('Email adresa')
        ];

        return view($this->_path . 'index', [
            'filters' => $filters,
            'locations' => $locations
        ]);
    }
    public function create(): View{
        return view($this->_path . 'create', [
            'create' => true,
            'cities' => City::pluck('title', 'id')
        ]);
    }
    public function save(Request $request): JsonResponse{
        try{
            $location = Location::create($request->except(['_token']));

            return $this->jsonSuccess(__('Uspješno spašeno'), route('system.admin.trainings.submodules.locations.preview', ['id' => $location->id ]));
        }catch (\Exception $e){
            return $this->jsonError('5200', __('Greška prilikom obrade podataka. Molimo kontaktirajte administratora!'));
        }
    }
    public function preview($id): View{
        return view($this->_path . 'create', [
            'preview' => true,
            'cities' => City::pluck('title', 'id'),
            'location' => Location::where('id', '=', $id)->first()
        ]);
    }
    public function edit($id): View{
        return view($this->_path . 'create', [
            'edit' => true,
            'cities' => City::pluck('title', 'id'),
            'location' => Location::where('id', '=', $id)->first()
        ]);
    }
    public function update(Request $request): JsonResponse{
        try{
            Location::where('id', '=', $request->id)->update($request->except(['_token', 'id']));

            return $this->jsonSuccess(__('Uspješno spašeno'), route('system.admin.trainings.submodules.locations.preview', ['id' => $request->id ]));
        }catch (\Exception $e){
            return $this->jsonError('5200', __('Greška prilikom obrade podataka. Molimo kontaktirajte administratora!'));
        }
    }
    public function delete($id): RedirectResponse{
        try{
            Location::where('id', '=', $id)->delete();
        }catch (\Exception $e){
            return redirect()->route('system.admin.trainings.submodules.locations.preview', ['id' => $id ]);
        }
        return redirect()->route('system.admin.trainings.submodules.locations');
    }
}
