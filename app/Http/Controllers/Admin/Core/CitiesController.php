<?php

namespace App\Http\Controllers\Admin\Core;

use App\Http\Controllers\Controller;
use App\Models\Core\City;
use App\Models\Core\Country;
use App\Models\Core\Keyword;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CitiesController extends Controller{
    protected string $_path = 'admin.app.core.cities.';

    public function index(): View{
        $cities = City::where('id', '>', 0);
        $cities = Filters::filter($cities);

        $filters = [
            'country_id' => __('Država'),
            'title' => 'Naziv',
            'type' => __('Vrsta')
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
}
