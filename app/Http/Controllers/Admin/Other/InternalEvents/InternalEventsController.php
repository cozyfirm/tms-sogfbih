<?php

namespace App\Http\Controllers\Admin\Other\InternalEvents;

use App\Http\Controllers\Admin\Core\Filters;
use App\Http\Controllers\Controller;
use App\Models\Core\City;
use App\Models\Core\File;
use App\Models\Core\Keyword;
use App\Models\Other\InternalEvents\IEFiles;
use App\Models\Other\InternalEvents\InternalEvent;
use App\Models\Trainings\Author;
use App\Models\Trainings\Instances\Instance;
use App\Models\Trainings\Instances\InstanceFile;
use App\Models\Trainings\Submodules\Locations\Location;
use App\Traits\Common\CommonTrait;
use App\Traits\Http\ResponseTrait;
use App\Traits\Trainings\TrainingTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class InternalEventsController extends Controller{
    use ResponseTrait, CommonTrait, TrainingTrait;
    protected string $_path = 'admin.app.other.internal-events.';


    public function index(): View{
        $events = InternalEvent::orderBy('id', 'DESC');
        $events = Filters::filter($events);

        $filters = [
            'title' => __('Naslov'),
            'categoryRel.name' => __('Kategorija'),
            'projectRel.name' => 'Projekat',
            'date' => __('Datum'),
            'time' => __('Vrijeme'),
            'participants' => __('Broj učesnika')
        ];

        return view($this->_path . 'index', [
            'filters' => $filters,
            'events' => $events
        ]);
    }

    public function create(): View{
        return view($this->_path . 'create', [
            'create' => true,
            'categories' => Keyword::getIt('ie__categories'),
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

            return $this->jsonSuccess(__('Uspješno spašeni podaci za događaj!'), route('system.admin.other.internal-events.preview', ['id' => $event->id ]));
        }catch (\Exception $e){
            return $this->jsonError('2000', __('Greška prilikom obrade podataka. Molmo kontaktirajte administratora!'));
        }
    }

    public function preview($id): View{
        return view($this->_path . 'preview', [
            'preview' => true,
            'categories' => Keyword::getIt('ie__categories'),
            'projects' => Keyword::getIt('ie__projects'),
            'locations' => Location::pluck('title', 'id'),
            'time' => $this->formTimeArr(),
            'event' => InternalEvent::where('id', '=', $id)->first()
        ]);
    }

    public function edit($id): View{
        return view($this->_path . 'create', [
            'edit' => true,
            'categories' => Keyword::getIt('ie__categories'),
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

            return $this->jsonSuccess(__('Uspješno ažurirani podaci za događaj!'), route('system.admin.other.internal-events.preview', ['id' => $request->id ]));
        }catch (\Exception $e){
            return $this->jsonError('2000', __('Greška prilikom obrade podataka. Molmo kontaktirajte administratora!'));
        }
    }

    /**
     * Delete event
     *
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id): RedirectResponse{
        try{
            $event = InternalEvent::where('id', '=', $id)->first();
            /** Fetch title of event */
            $title = $event->title;
            /** Delete event */
            $event->delete();

            return redirect()->route('system.admin.other.internal-events')->with('success', __('Uspješno obrisan događaj ' . $title . "!"));
        }catch (\Exception $e){ return back()->with('error', __('Došlo je do greške. Molimo kontaktirajte administratora!')); }
    }

    /**
     * Save files as relationship
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function saveFiles(Request $request): JsonResponse{
        try{
            foreach ($request->filesArray as $item){
                IEFiles::create([
                    'event_id' => $request->model_id,
                    'file_id' => $item['fileID']
                ]);
            }

            return $this->jsonSuccess(__('Uspješno sačuvano'), route('system.admin.other.internal-events.preview', ['id' => $request->model_id]));
        }catch (\Exception $e){
            return $this->jsonError('2000', __('Greška prilikom obrade podataka. Molmo kontaktirajte administratora!'));
        }
    }

    /**
     * Start file download
     *
     * @param $id
     * @return BinaryFileResponse
     */
    public function downloadFile($id): BinaryFileResponse{
        try{
            $file = File::where('id', '=', $id)->first();

            return response()->download(storage_path('files/other/ie/' . $file->name), $file->file);
        }catch (\Exception $e){}
    }

    /**
     * Remove file from training and from files__table
     *
     * @param $id
     * @return RedirectResponse
     */
    public function removeFile($id): RedirectResponse{
        try{
            /** @var $rel; Find instance_file */
            $rel = IEFiles::where('file_id', '=', $id)->first();
            /** Remove file */
            File::where('id', '=', $id)->delete();
            /** @var $modelID; Find instance ID */
            $modelID = $rel->instance_id;
            /** Remove instance_file */
            $rel->delete();

            return back();
            // return redirect()->route('system.admin.other.internal-events.preview', ['id' => $modelID]);
        }catch (\Exception $e){
            return back();
        }
    }

    /**
     *  Photo Gallery
     */
    public function photoGallery($id): View{
        return view($this->_path . 'gallery', [
            'event' => InternalEvent::where('id', '=', $id)->first()
        ]);
    }
}
