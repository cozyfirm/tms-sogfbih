<?php

namespace App\Http\Controllers\Admin\Core;

use App\Http\Controllers\Controller;
use App\Models\Trainings\Instances\InstanceApp;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CoreController extends Controller{
    protected string $_path = 'admin.app.core.';

    public function index(): View{
        return view($this->_path. 'core', [
            'lastApplications' => InstanceApp::orderBy('id', 'DESC')->take(3)->get()
        ]);
    }
}
