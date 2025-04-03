<?php

namespace App\Http\Controllers\UserData\Trainings;

use App\Http\Controllers\Admin\Core\Filters;
use App\Http\Controllers\Controller;
use App\Models\Core\Keyword;
use App\Models\Trainings\Evaluations\Evaluation;
use App\Models\Trainings\Evaluations\EvaluationOption;
use App\Models\Trainings\Evaluations\EvaluationStatus;
use App\Models\Trainings\Instances\Instance;
use App\Models\Trainings\Instances\InstanceApp;
use App\Models\Trainings\Submodules\Locations\Location;
use App\Models\Trainings\Training;
use App\Models\User;
use App\Traits\Common\CommonTrait;
use App\Traits\Http\ResponseTrait;
use App\Traits\Users\UserBaseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use PhpParser\PrettyPrinter\Standard;

class TrainingsController extends Controller{
    use UserBaseTrait, ResponseTrait, CommonTrait;

    protected string $_path = 'user-data.trainings.';

    public function getTrainings($instances, $header): View{
        $instances = Filters::filter($instances);

        $filters = [
            'trainingRel.title' => 'Naziv',
            'application_date' => __('Datum za prijave'),
            'trainers__' => __('Treneri na obuci'),
            'total_applications' => __('Broj prijavljenih kandidata')
        ];

        return view($this->_path . 'index', [
            'filters' => $filters,
            'instances' => $instances,
            'header' => $header
        ]);
    }
    public function index(): View{
        $instances = Instance::where('application_date','>=', date('Y-m-d'))->orderBy('application_date', 'DESC');
        return $this->getTrainings($instances, "Sistem obuka");
    }
    public function myTrainings(): View{
        $instances = Instance::whereHas('acceptedApplicationsRel', function ($query){
            $query->where('status', '=', 2);
        })->orderBy('application_date', 'DESC');
        return $this->getTrainings($instances, "Moje obuke");
    }

    public function preview($id): View{
        $instance = Instance::where('id', '=', $id)->first();

        $evaluation = Evaluation::where('type', '=','__training')->where('model_id', '=', $id)->first();
        if($evaluation){
            $groups     = EvaluationOption::where('evaluation_id', '=', $evaluation->id)->orderBy('group_by')->get()->unique('group_by');
            $status     = EvaluationStatus::where('evaluation_id', '=', $evaluation->id)->where('user_id', '=', Auth::user()->id)->first();
        }

        return view($this->_path . 'preview', [
            'preview' => true,
            'programs' => Training::pluck('title', 'id')->prepend('Odaberite program'),
            'yesNo' => Keyword::getItByVal('yes_no'),
            'instance' => $instance,
            'trainers' => User::where('role', '=', 'trainer')->pluck('name', 'id')->prepend('Odaberite trenera', '0'),
            'events' => Keyword::getItByVal('event_type'),
            'locations' => Location::pluck('title', 'id')->prepend('Odaberite lokaciju', '0'),
            'time' => $this->formTimeArr(),
            'application' => InstanceApp::where('instance_id', '=', $id)->where('user_id', '=', Auth::user()->id)->first(),
            'evaluation' => $evaluation,
            'groups' => $groups ?? [],
            'status' => $status ?? null
        ]);
    }

    public function photoGallery($instance_id): View{
        return view($this->_path . 'additional-data.photo-gallery', [
            "create" => true,
            'instance' => Instance::where('id', '=', $instance_id)->first()
        ]);
    }
}
