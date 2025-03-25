<?php

namespace App\Http\Controllers\Admin\Trainings;

use App\Http\Controllers\Admin\Core\Filters;
use App\Http\Controllers\Controller;
use App\Models\Core\File;
use App\Models\Core\Keyword;
use App\Models\Trainings\Instances\Instance;
use App\Models\Trainings\Instances\InstanceDate;
use App\Models\Trainings\Instances\InstanceFile;
use App\Models\Trainings\Instances\InstanceLunch;
use App\Models\Trainings\Submodules\Locations\Location;
use App\Models\Trainings\Training;
use App\Models\Trainings\TrainingFile;
use App\Models\User;
use App\Traits\Common\CommonTrait;
use App\Traits\Common\FileTrait;
use App\Traits\Http\ResponseTrait;
use App\Traits\Trainings\TrainingTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class InstancesController extends Controller{
    use ResponseTrait, CommonTrait, TrainingTrait, FileTrait;

    protected string $_path = 'admin.app.trainings.instances.';
    protected string $_invoice_path = 'files/trainings/instances/invoices';

    public function index(): View{
        $instances = Instance::orderBy('application_date', 'DESC');
        $instances = Filters::filter($instances);

        $filters = [
            'trainingRel.title' => 'Naziv',
            'application_date' => __('Datum za prijave'),
            'contract' => __('Vrijednost ugovora'),
            'reportRel.name' => __('Izvještaj o provedenoj obuci')
        ];

        return view($this->_path . 'index', [
            'filters' => $filters,
            'instances' => $instances
        ]);
    }

    public function getData($action, $id = null): View{
        return view($this->_path . 'create', [
            $action => true,
            'programs' => Training::pluck('title', 'id')->prepend('Odaberite program', '0'),
            'yesNo' => Keyword::getItByVal('yes_no'),
            'instance' => isset($id) ? Instance::where('id', '=', $id)->first() : null
        ]);
    }
    public function create(): View{
        return $this->getData('create');
    }

    /**
     * Save instance; Possible file can be included inside request
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function save(Request $request): JsonResponse{
        try{
            $request['application_date'] = Carbon::parse($request->application_date)->format('Y-m-d');
            $request['created_by'] = Auth::user()->id;

            // Create instance
            $instance = Instance::create($request->except(['_token']));

            return $this->jsonSuccess(__('Uspješno unesena obuka!'), route('system.admin.trainings.instances.preview', ['id' => $instance->id ]));
        }catch (\Exception $e){
            return $this->jsonError('2000', __('Greška prilikom obrade podataka. Molmo kontaktirajte administratora!'));
        }
    }

    public function preview($id): View{
        $instance = Instance::where('id', '=', $id)->first();

        return view($this->_path . 'preview', [
            'preview' => true,
            'programs' => Training::pluck('title', 'id')->prepend('Odaberite program', '0'),
            'yesNo' => Keyword::getItByVal('yes_no'),
            'instance' => $instance,
            'trainers' => User::where('role', '=', 'trainer')->pluck('name', 'id')->prepend('Odaberite trenera', '0'),
            'events' => Keyword::getItByVal('event_type'),
            'locations' => Location::pluck('title', 'id')->prepend('Odaberite lokaciju', '0'),
            'time' => $this->formTimeArr(5)
        ]);
    }
    public function edit($id): View{
        return $this->getData('edit', $id, $id);
    }

    public function update(Request $request): JsonResponse{
        try{
            $request['application_date'] = Carbon::parse($request->application_date)->format('Y-m-d');

            // Update instance
            Instance::where('id', '=', $request->id)->update($request->except(['_token', 'id']));

            return $this->jsonSuccess(__('Uspješno ažurirano!'), route('system.admin.trainings.instances.preview', ['id' => $request->id ]));
        }catch (\Exception $e){
            return $this->jsonError('2000', __('Greška prilikom obrade podataka. Molmo kontaktirajte administratora!'));
        }
    }

    public function delete($id): RedirectResponse{
        try{
            // Instance::where('id', '=', $id)->delete();
            return redirect()->route('system.admin.trainings.instances');
        }catch (\Exception $e){
            return back();
        }
    }

    /**
     * Save files as relationship
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function saveFiles(Request $request): JsonResponse{
        try{
            if($request->status == 'unknown') $request['status'] = 'private';

            foreach ($request->filesArray as $item){
                InstanceFile::create([
                    'instance_id' => $request->model_id,
                    'file_id' => $item['fileID'],
                    'user_id' => Auth::user()->id,
                    'visibility' => $request->status
                ]);
            }

            return $this->jsonSuccess(__('Uspješno sačuvano'), route('system.admin.trainings.instances.preview', ['id' => $request->model_id]));
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

            return response()->download(storage_path('files/trainings/instances/files/' . $file->name), $file->file);
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
            $rel = InstanceFile::where('file_id', '=', $id)->first();
            /** Remove file */
            File::where('id', '=', $id)->delete();
            /** @var $modelID; Find instance ID */
            $modelID = $rel->instance_id;
            /** Remove instance_file */
            $rel->delete();

            return back();
            // return redirect()->route('system.admin.trainings.instances.preview', ['id' => $modelID]);
        }catch (\Exception $e){
            return back();
        }
    }

    /**
     *  Photo Gallery
     */
    public function photoGallery($id): View{
        return view($this->_path . 'submodules.photo-gallery.preview', [
            "create" => true,
            'instance' => Instance::where('id', '=', $id)->first()
        ]);
    }

    /* -------------------------------------------------------------------------------------------------------------- */
    /**
     *  Submodules:
     *      1. Reports
     */

    /**
     * Update report: Return view for selecting report file
     * @param $instance_id
     * @return View
     */
    public function editReport($instance_id): View{
        $instance = Instance::where('id', '=', $instance_id)->first();

        return view($this->_path . 'submodules.reports.report', [
            "instance" => $instance,
        ]);
    }

    /**
     * Update report info: Rise report flag and add file
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateReport(Request $request): RedirectResponse{
        try{
            $request['file_path'] = (storage_path('files/trainings/instances/reports'));
            $file = $this->saveFile($request, 'report', 'instance_report');

            Instance::where('id', '=', $request->instance_id)->update([
                'report' => 1,
                'report_id' => $file->id
            ]);

            return redirect()->route('system.admin.trainings.instances.preview', ['id' => $request->instance_id]);
        }catch (\Exception $e){
            return back();
        }
    }

    public function downloadReport($instance_id): BinaryFileResponse{
        try{
            $instance = Instance::where('id', '=', $instance_id)->first();
            $file = File::where('id', '=', $instance->report_id)->first();

            return response()->download(storage_path('files/trainings/instances/reports/' . $file->name), $file->file);
        }catch (\Exception $e){}
    }
}
