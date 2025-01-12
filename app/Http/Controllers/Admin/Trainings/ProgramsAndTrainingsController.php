<?php

namespace App\Http\Controllers\Admin\Trainings;

use App\Http\Controllers\Admin\Core\Filters;
use App\Http\Controllers\Controller;
use App\Models\Core\Keyword;
use App\Models\Trainigs\Training;
use App\Traits\Common\CommonTrait;
use App\Traits\Http\ResponseTrait;
use App\Traits\Trainings\TrainingTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProgramsAndTrainingsController extends Controller{
    use ResponseTrait, CommonTrait, TrainingTrait;
    protected string $_path = 'admin.app.trainings.';

    public function home(): View{
        return view($this->_path . 'home');
    }
    public function index(): View{
        $trainings = Training::orderBy('year', 'DESC');
        $trainings = Filters::filter($trainings);

        $filters = [
            'title' => 'Naziv',
            'author' => __('Autor'),
            'financedByRel.name' => __('Izradu programa obuke finansirao'),
            'projectRel.name' => __('Program obuke izrađen u okviru projekta'),
            'countryRel.name_ba' => __('Godina')
        ];

        return view($this->_path . 'index', [
            'filters' => $filters,
            'trainings' => $trainings
        ]);
    }
    public function getData($action, $id = null): View{
        return view($this->_path . 'create', [
            $action => true,
            'areas' => Keyword::getIt('trainings__areas'),
            'financiers' => Keyword::getIt('trainings__financed_by'),
            'projects' => Keyword::getIt('trainings__projects'),
            'training' => isset($id) ? Training::where('id', '=', $id)->first() : null
        ]);
    }

    public function create(): View{
        return $this->getData('create');
    }

    public function save(Request $request): JsonResponse{
        try{
            $select2 = $this->extractSelect2($request->areas);
            $training = Training::create($request->except(['_token', 'areas', 'undefined']));
            /**
             *  If not defined, insert areas into table and create samples for this training
             */
            $this->handleAreas($select2, $training->id);

            return $this->jsonSuccess(__('Uspješno spašen program obuke!'), route('system.admin.trainings.preview', ['id' => $training->id ]));
        }catch (\Exception $e){
            return $this->jsonError('2000', __('Greška prilikom obrade podataka. Molmo kontaktirajte administratora!'));
        }
    }

    public function preview($id): View{
        return view($this->_path . 'preview', [
            'preview' => true,
            'areas' => Keyword::getIt('trainings__areas'),
            'financiers' => Keyword::getIt('trainings__financed_by'),
            'projects' => Keyword::getIt('trainings__projects'),
            'training' => isset($id) ? Training::where('id', '=', $id)->first() : null
        ]);
    }

    public function edit($id): View{
        return $this->getData('edit', $id);
    }

    public function update(Request $request): JsonResponse{
        try{
            $select2 = $this->extractSelect2($request->areas);
            Training::where('id', '=', $request->id)->update($request->except(['_token', 'id', 'areas', 'undefined']));

            /**
             *  If not defined, insert areas into table and create samples for this training
             */
            $this->handleAreas($select2, $request->id);

            return $this->jsonSuccess(__('Uspješno spašen program obuke!'), route('system.admin.trainings.preview', ['id' => $request->id ]));
        }catch (\Exception $e){
            dd($e);
            return $this->jsonError('2000', __('Greška prilikom obrade podataka. Molmo kontaktirajte administratora!'));
        }
    }
}
