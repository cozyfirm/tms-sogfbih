<?php

namespace App\Http\Controllers\Admin\Other\InternalEvents;

use App\Http\Controllers\Admin\Core\Filters;
use App\Http\Controllers\Controller;
use App\Models\Core\City;
use App\Models\Core\Keyword;
use App\Models\Other\InternalEvents\InternalEvent;
use App\Models\Trainings\Author;
use App\Models\Trainings\Instances\Instance;
use App\Models\Trainings\Submodules\Locations\Location;
use App\Traits\Common\CommonTrait;
use App\Traits\Http\ResponseTrait;
use App\Traits\Trainings\TrainingTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class InternalEventsController extends Controller{
    use ResponseTrait, CommonTrait, TrainingTrait;
    protected string $_path = 'admin.app.other.internal-events.';


    public function index(): View{
        $events = InternalEvent::orderBy('title', 'DESC');
        $events = Filters::filter($events);

        $filters = [
            'project' => 'Projekat',
            'date' => __('Datum'),
            'time' => __('Vrijeme')
        ];

        return view($this->_path . 'index', [
            'filters' => $filters,
            'events' => $events
        ]);
    }

    public function create(): View{
        return view($this->_path . 'create', [
            'create' => true,
            'projects' => Keyword::getIt('ie__projects'),
            'locations' => Location::pluck('title', 'id'),
            'time' => $this->formTimeArr()
        ]);
    }

    public function save(Request $request): JsonResponse{
        try{
            $request['date'] = Carbon::parse($request->date)->format('Y-m-d');

            // Create instance
            $event = InternalEvent::create($request->except(['_token']));

            return $this->jsonSuccess(__('Uspješno unesena obuka!'), route('system.admin.other.internal-events.preview', ['id' => $event->id ]));
        }catch (\Exception $e){
            return $this->jsonError('2000', __('Greška prilikom obrade podataka. Molmo kontaktirajte administratora!'));
        }
    }

    public function preview($id): View{
        return view($this->_path . 'preview', [
            'preview' => true,
            'projects' => Keyword::getIt('ie__projects'),
            'locations' => Location::pluck('title', 'id'),
            'time' => $this->formTimeArr(),
            'event' => InternalEvent::where('id', '=', $id)->first()
        ]);
    }

    public function edit($id): View{
        return view($this->_path . 'create', [
            'edit' => true,
            'projects' => Keyword::getIt('ie__projects'),
            'locations' => Location::pluck('title', 'id'),
            'time' => $this->formTimeArr(),
            'event' => InternalEvent::where('id', '=', $id)->first()
        ]);
    }

    public function update(Request $request): JsonResponse{
        try{
            $request['date'] = Carbon::parse($request->date)->format('Y-m-d');

            // Create instance
            InternalEvent::where('id', '=', $request->id)->update($request->except(['_token']));

            return $this->jsonSuccess(__('Uspješno unesena obuka!'), route('system.admin.other.internal-events.preview', ['id' => $request->id ]));
        }catch (\Exception $e){
            return $this->jsonError('2000', __('Greška prilikom obrade podataka. Molmo kontaktirajte administratora!'));
        }
    }
}
