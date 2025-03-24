<?php

namespace App\Http\Controllers\Admin\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CoreController extends Controller{
    protected string $_path = 'admin.app.core.';

    public function index(): View{
        return view($this->_path. 'core');
    }
}
