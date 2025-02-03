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
            'contract' => __('Vrijednost ugovora')
        ];

        return view($this->_path . 'index', [
            'filters' => $filters,
            'instances' => $instances
        ]);
    }

    public function getData($action, $id = null): View{
        return view($this->_path . 'create', [
            $action => true,
            'programs' => Training::pluck('title', 'id')->prepend('Odaberite program'),
            'yesNo' => Keyword::getItByVal('yes_no')
        ]);
    }
    public function create(): View{
        return $this->getData('create');
    }

    public function save(Request $request): JsonResponse{
        try{
            $request['application_date'] = Carbon::parse($request->application_date)->format('Y-m-d');

            // Create instance
            $instance = Instance::create($request->except(['_token']));

            // Check if lunch is included
            if($request->lunch == 1){
                //
                return $this->jsonSuccess(__('Uspješno unesena obuka. Molimo unesite informacija o ručku!'), route('system.admin.trainings.instances.lunch.add', ['instance_id' => $instance->id ]));
            }else{

            }
        }catch (\Exception $e){
            return $this->jsonError('2000', __('Greška prilikom obrade podataka. Molmo kontaktirajte administratora!'));
        }
    }

    public function preview($id): View{
        $instance = Instance::where('id', '=', $id)->first();
        return view($this->_path . 'preview', [
            'preview' => true,
            'programs' => Training::pluck('title', 'id')->prepend('Odaberite program'),
            'yesNo' => Keyword::getItByVal('yes_no'),
            'instance' => $instance,
            'trainers' => User::where('role', '=', 'trainer')->pluck('name', 'id')->prepend('Odaberite trenera', '0'),
            'events' => Keyword::getItByVal('event_type'),
            'locations' => Location::pluck('title', 'id')->prepend('Odaberite lokaciju', '0'),
            'time' => $this->formTimeArr()
        ]);
    }

    /**
     *  Lunch info
     */

    public function addLunch($id): View{
        return view($this->_path . 'lunch.create', [
            "create" => true,
            'instance' => Instance::where('id', '=', $id)->first()
        ]);
    }
    public function saveLunch(Request $request): RedirectResponse{
        try{
            $request['path'] = (storage_path($this->_invoice_path));
            $file = $this->saveFile($request, 'invoice', 'instances__invoices');

            $request['invoice_id'] = $file->id;

            InstanceLunch::create($request->except(['_token', 'repeat', 'invoice']));

            if(isset($request->repeat)){
                return back();
            }else{
                return redirect()->route('system.admin.trainings.instances.date.add', ['instance_id' => $request->instance_id]);
            }

        }catch (\Exception $e){
            return back()->with('error', __('Desila se greška. Molimo kontaktirajte administratora!'));
        }
    }

    /**
     *  Date info
     */
    public function addDate($id): View{
        return view($this->_path . 'date.create', [
            "create" => true,
            'instance' => Instance::where('id', '=', $id)->first(),
            'time' => $this->formTimeArr()
        ]);
    }

    public function saveDate(Request $request): JsonResponse{
        try{
            $request['date'] = Carbon::parse($request->date)->format('Y-m-d');
            $date = InstanceDate::create($request->except(['_token']));

            if(isset($request->repeat)){
                return $this->jsonSuccess(__('Uspješno spašeno!'), route('system.admin.trainings.instances.date.add', ['instance_id' => $request->instance_id ]));
            }else{
                return $this->jsonSuccess(__('Uspješno spašeno!'), route('system.admin.trainings.instances.preview', ['id' => $request->instance_id ]));
            }
        }catch (\Exception $e){
            return $this->jsonError('2000', __('Greška prilikom obrade podataka. Molmo kontaktirajte administratora!'));
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
            foreach ($request->filesArray as $item){
                InstanceFile::create([
                    'instance_id' => $request->model_id,
                    'file_id' => $item['fileID'],
                    'user_id' => Auth::user()->id
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
            $rel = InstanceFile::where('id', '=', $id)->first();
            $file = File::where('id', '=', $rel->file_id)->first();

            return response()->download(storage_path('files/trainings/' . $file->name), $file->file);
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
            $rel = InstanceFile::where('id', '=', $id)->first();
            File::where('id', '=', $rel->file_id)->delete();
            $modelID = $rel->training_id;
            $rel->delete();

            return redirect()->route('system.admin.trainings.preview', ['id' => $modelID]);
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
}
