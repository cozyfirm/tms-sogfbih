<?php

namespace App\Http\Controllers\UserData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller{
    protected string $_path = 'user-data.';

    public function dashboard(): View{
        return view($this->_path . 'dashboard', [

        ]);
    }
}
