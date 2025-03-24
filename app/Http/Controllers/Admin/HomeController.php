<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trainings\Instances\Instance;
use App\Models\Trainings\Training;
use App\Models\User;
use App\Models\Users\SystemAccess;
use App\Traits\Mqtt\MqttTrait;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller{
    use MqttTrait;

    /**
     * Admin Dashboard
     * @return View
     */
    public function index(): View{
        return view('admin.home', [
            'trainings' => Training::count(),
            'users' => User::where('role', '!=', 'admin')->count(),
            'trainers' => User::where('role', '=', 'trainer')->count(),
            'instances' => Instance::count(),
            'systemAccess' => SystemAccess::orderBy('id', 'DESC')->take(5)->get()
        ]);
    }
}
