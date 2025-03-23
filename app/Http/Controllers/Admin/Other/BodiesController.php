<?php

namespace App\Http\Controllers\Admin\Other;

use App\Http\Controllers\Admin\Core\Filters;
use App\Http\Controllers\Controller;
use App\Models\Core\File;
use App\Models\Core\Keyword;
use App\Models\Other\Bodies\Bodies;
use App\Models\Other\Bodies\BodyFiles;
use App\Models\Other\InternalEvents\InternalEvent;
use App\Models\Trainings\Submodules\Locations\Location;
use App\Traits\Common\CommonTrait;
use App\Traits\Http\ResponseTrait;
use App\Traits\Trainings\TrainingTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BodiesController extends Controller{
    use ResponseTrait, CommonTrait, TrainingTrait;
    protected string $_path = 'admin.app.other.bodies.';


    public function index(): View{
        $bodies = Bodies::orderBy('id', 'DESC');
        $bodies = Filters::filter($bodies);

        $filters = [
            'title' => 'Naslov',
            'categoryRel.name' => __('Kategorija'),
            'date' => __('Datum'),
            'time' => __('Vrijeme'),
            'participants' => __('Broj učesnika')
        ];

        return view($this->_path . 'index', [
            'filters' => $filters,
            'bodies' => $bodies
        ]);
    }

    public function create(): View{
        return view($this->_path . 'create', [
            'create' => true,
            'categories' => Keyword::getIt('bodies__category'),
            'locations' => Location::pluck('title', 'id'),
            'time' => $this->formTimeArr()
        ]);
    }

    public function save(Request $request): JsonResponse{
        try{
            $request['date'] = Carbon::parse($request->date)->format('Y-m-d');

            // Create instance
            $body = Bodies::create($request->except(['_token']));

            return $this->jsonSuccess(__('Uspješno unesena obuka!'), route('system.admin.other.bodies.preview', ['id' => $body->id ]));
        }catch (\Exception $e){
            return $this->jsonError('2000', __('Greška prilikom obrade podataka. Molmo kontaktirajte administratora!'));
        }
    }

    public function preview($id): View{
        return view($this->_path . 'preview', [
            'preview' => true,
            'categories' => Keyword::getIt('bodies__category'),
            'locations' => Location::pluck('title', 'id'),
            'time' => $this->formTimeArr(),
            'body' => Bodies::where('id', '=', $id)->first()
        ]);
    }

    public function edit($id): View{
        return view($this->_path . 'create', [
            'edit' => true,
            'categories' => Keyword::getIt('bodies__category'),
            'locations' => Location::pluck('title', 'id'),
            'time' => $this->formTimeArr(),
            'body' => Bodies::where('id', '=', $id)->first()
        ]);
    }

    public function update(Request $request): JsonResponse{
        try{
            $request['date'] = Carbon::parse($request->date)->format('Y-m-d');

            // Create instance
            Bodies::where('id', '=', $request->id)->update($request->except(['_token']));

            return $this->jsonSuccess(__('Uspješno unesena obuka!'), route('system.admin.other.bodies.preview', ['id' => $request->id ]));
        }catch (\Exception $e){
            return $this->jsonError('2000', __('Greška prilikom obrade podataka. Molmo kontaktirajte administratora!'));
        }
    }

    public function delete($id): RedirectResponse{
        try{
            Bodies::where('id', '=', $id)->delete();
            return redirect()->route('system.admin.other.bodies')->with('success', __('Uspješno obrisano!'));
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
                BodyFiles::create([
                    'body_id' => $request->model_id,
                    'file_id' => $item['fileID']
                ]);
            }

            return $this->jsonSuccess(__('Uspješno sačuvano'), route('system.admin.other.bodies.preview', ['id' => $request->model_id]));
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

            return response()->download(storage_path('files/other/bodies/' . $file->name), $file->file);
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
            $rel = BodyFiles::where('file_id', '=', $id)->first();
            /** Remove file */
            File::where('id', '=', $id)->delete();
            /** @var $modelID; Find instance ID */
            $modelID = $rel->instance_id;
            /** Remove instance_file */
            $rel->delete();

            return back();
            // return redirect()->route('system.admin.other.bodies.preview', ['id' => $modelID]);
        }catch (\Exception $e){
            return back();
        }
    }

    /**
     *  Photo Gallery
     */
    public function photoGallery($id): View{
        return view($this->_path . 'gallery', [
            'body' => Bodies::where('id', '=', $id)->first()
        ]);
    }
}
