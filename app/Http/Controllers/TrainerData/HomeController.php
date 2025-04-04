<?php

namespace App\Http\Controllers\TrainerData;

use App\Http\Controllers\Controller;
use App\Models\Trainings\Instances\Instance;
use App\Models\Trainings\Instances\InstanceApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller{
    protected string $_path = 'trainer-data.';

    public function dashboard(): View{
        return view($this->_path . 'dashboard', [
            'instances' => Instance::where('application_date','>=', date('Y-m-d'))->count()
        ]);
    }
}
