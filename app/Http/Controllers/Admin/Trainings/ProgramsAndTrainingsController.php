<?php

namespace App\Http\Controllers\Admin\Trainings;

use App\Http\Controllers\Admin\Core\Filters;
use App\Http\Controllers\Controller;
use App\Models\Core\City;
use App\Models\Core\Keyword;
use App\Models\Trainigs\Author;
use App\Models\Trainigs\AuthorRel;
use App\Models\Trainigs\Training;
use App\Models\Trainigs\TrainingFile;
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
            'participants' => Keyword::getIt('trainings__participants'),
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
            'participants' => Keyword::getIt('trainings__participants'),
            'training' => isset($id) ? Training::where('id', '=', $id)->first() : null,
            'cities' => City::pluck('title', 'id'),
            'userTypes' => Keyword::getIt('user_type'),
            'authors' => Author::get()->pluck('full_name', 'id')
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
            return $this->jsonError('2000', __('Greška prilikom obrade podataka. Molmo kontaktirajte administratora!'));
        }
    }

    /**
     * Save author and create relationship to training
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function saveAuthor(Request $request): JsonResponse {
        try{
            if($request->updateAuthor === "true"){
                /* Update existing author */

                Author::where('id', '=', $request->authorGlobalID)->update([
                    'type' => $request->type,
                    'title' => $request->title,
                    'address' => $request->address,
                    'city' => $request->city,
                    'phone' => $request->phone,
                    'cellphone' => $request->cellphone,
                    'email' => $request->email,
                    'comment' => $request->comment
                ]);

                return $this->jsonSuccess(__('Uspješno ažurirano!! '), route('system.admin.trainings.preview', ['id' => $request->training_id ]));
            }else{
                /* Add new author */
                if($request->switchState == "on"){
                    /* Add new author */
                    $author = Author::create([
                        'type' => $request->type,
                        'title' => $request->title,
                        'address' => $request->address,
                        'city' => $request->city,
                        'phone' => $request->phone,
                        'cellphone' => $request->cellphone,
                        'email' => $request->email,
                        'comment' => $request->comment
                    ]);
                }else{
                    $author = Author::where('id', '=', $request->search_author)->first();
                }

                $rel = AuthorRel::where('training_id', '=', $request->training_id)->where('author_id', '=', $author->id)->first();
                if(!$rel){
                    AuthorRel::create([
                        'training_id' => $request->training_id,
                        'author_id' => $author->id
                    ]);
                }else{
                    return $this->jsonError('2001', __('Željeni autor je već povezan sa ovim programom obuke!'));
                }

                return $this->jsonSuccess(__('Uspješno spašen autor programa obuke'), route('system.admin.trainings.preview', ['id' => $request->training_id ]));
            }
        }catch (\Exception $e){
            return $this->jsonError('2000', __('Greška prilikom obrade podataka. Molmo kontaktirajte administratora!'));
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function fetchAuthor(Request $request): JsonResponse{
        try{
            $author = Author::where('id', '=', $request->authorID)->first();
            return $this->apiResponse('0000', __('Success'), [
                'author' => $author
            ]);
        }catch (\Exception $e){
            return $this->jsonError('2000', __('Greška prilikom obrade podataka. Molmo kontaktirajte administratora!'));
        }
    }

    public function saveFiles(Request $request): JsonResponse{
        try{
            foreach ($request->filesArray as $item){
                TrainingFile::create([
                    'training_id' => $request->model_id,
                    'file_id' => $item['fileID']
                ]);
            }

            return $this->jsonSuccess(__('Uspješno sačuvano'), route('system.admin.trainings.preview', ['id' => $request->model_id]));
        }catch (\Exception $e){
            return $this->jsonError('2000', __('Greška prilikom obrade podataka. Molmo kontaktirajte administratora!'));
        }
    }
}
