<?php

namespace App\Http\Controllers\Admin\Trainings\Submodules;

use App\Http\Controllers\Admin\Core\Filters;
use App\Http\Controllers\Controller;
use App\Models\Trainings\Evaluations\Evaluation;
use App\Models\Trainings\Submodules\Locations\Location;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EvaluationsController extends Controller{
    protected string $_path = 'admin.app.trainings.submodules.evaluations.';

    public function index(): View{
        $evaluations = Evaluation::orderBy('id', 'DESC');
        $evaluations = Filters::filter($evaluations);

        $filters = [
            'modelRel.title' => __('Evaluacija'),
            'lockedRel.name' => __('Zaključana'),
            'submissions' => __('Broj ispitanika')
        ];

        return view($this->_path . 'index', [
            'filters' => $filters,
            'evaluations' => $evaluations
        ]);
    }
}
