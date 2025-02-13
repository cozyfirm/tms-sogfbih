<?php

namespace App\Http\Controllers\UserData;

use App\Http\Controllers\Controller;
use App\Models\Trainings\Instances\Instance;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller{
    protected string $_path = 'user-data.';

    public function dashboard(): View{
        return view($this->_path . 'dashboard', [
            'instances' => Instance::where('application_date','>=', date('Y-m-d'))->count()
        ]);
    }
}
