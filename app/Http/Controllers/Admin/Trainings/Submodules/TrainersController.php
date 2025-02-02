<?php

namespace App\Http\Controllers\Admin\Trainings\Submodules;

use App\Http\Controllers\Admin\Core\Filters;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\Common\CommonTrait;
use App\Traits\Http\ResponseTrait;
use App\Traits\Trainings\TrainingTrait;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrainersController extends Controller{
    use ResponseTrait, CommonTrait, TrainingTrait;

    protected string $_path = 'admin.app.trainings.submodules.trainers.';

    public function index(): View{
        $users = User::where('role', '=', 'trainer');
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
}
