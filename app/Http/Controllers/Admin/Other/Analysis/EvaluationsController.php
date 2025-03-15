<?php

namespace App\Http\Controllers\Admin\Other\Analysis;

use App\Http\Controllers\Admin\Core\Filters;
use App\Http\Controllers\Controller;
use App\Mail\Evaluations\NotifyApplicants;
use App\Models\Core\Keyword;
use App\Models\Other\Analysis\Analysis;
use App\Models\Trainings\Evaluations\Evaluation;
use App\Models\Trainings\Evaluations\EvaluationOption;
use App\Models\Trainings\Instances\Instance;
use App\Models\Trainings\Instances\InstanceApp;
use App\Traits\Common\CommonTrait;
use App\Traits\Http\ResponseTrait;
use App\Traits\Users\UserBaseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class EvaluationsController extends Controller{
    use ResponseTrait, CommonTrait, UserBaseTrait;

    protected string $_path = 'admin.app.other.analysis.submodules.evaluations.';

    /**
     * If there is no evaluation, create one
     *
     * @param $analysis_id
     * @return false
     */
    public function checkForEvaluation($analysis_id): mixed{
        try{
            $evaluation = Evaluation::where('type', '=', '__analysis')->where('model_id', '=', $analysis_id)->first();

            if(!$evaluation){
                $evaluation = Evaluation::create([
                    'type' => '__analysis',
                    'model_id' => $analysis_id
                ]);
            }

            return $evaluation;
        }catch (\Exception $e){
            return false;
        }
    }

    public function preview($analysis_id): View{
        $evaluation = $this->checkForEvaluation($analysis_id);

        $analysis = Analysis::where('id','=',$analysis_id)->first();
        $options  = EvaluationOption::whereHas('evaluationRel', function ($q) use($analysis){
            $q->where('model_id','=',$analysis->id)->where('type', '=', '__analysis');
        })->orderBy('group_by');

        $options = Filters::filter($options);

        $filters = [
            'groupRel.name' => 'Grupa pitanja',
            'typeRel.name' => __('Vrsta pitanja'),
            'question' => __('Pitanje'),
            'description' => __('Opis pitanja')
        ];

        return view($this->_path. 'preview',[
            'analysis' => $analysis,
            'filters' => $filters,
            'options' => $options,
            'evaluation' => $evaluation
        ]);
    }

    public function addOption($analysis_id): View{
        $analysis = Analysis::where('id','=',$analysis_id)->first();

        return view($this->_path. 'add-option', [
            'create' => true,
            'analysis' => $analysis,
            'groups' => Keyword::getIt('evaluation__groups')->prepend('Odaberite grupu', ''),
            'types' => Keyword::getItByVal('evaluation__question_type')
        ]);
    }

    public function saveOption(Request $request): JsonResponse{
        try{

            $evaluation = $this->checkForEvaluation($request->analysis_id);
            if($evaluation){
                /** Add evaluation */
                EvaluationOption::create([
                    'evaluation_id' => $evaluation->id,
                    'group_by' => $request->group_by,
                    'type' => $request->type,
                    'question' => $request->question,
                    'description' => $request->description
                ]);

                if(isset($request->repeat)){
                    return $this->jsonSuccess(__('Uspješno spašeno'), route('system.admin.other.analysis.submodules.evaluations.add-option', ['analysis_id' => $request->analysis_id]));
                }else{
                    return $this->jsonSuccess(__('Uspješno spašeno'), route('system.admin.other.analysis.submodules.evaluations.preview', ['analysis_id' => $request->analysis_id]));
                }
            }else{
                return $this->jsonError('5251', __('Desila se greška. Molimo kontaktirajte administratora'));
            }
        }catch (\Exception $e){
            return $this->jsonError('5250', __('Desila se greška. Molimo kontaktirajte administratora'));
        }
    }

    public function previewOption($id): View{
        $option   = EvaluationOption::where('id', '=', $id)->first();
        $evaluation = Evaluation::where('id', '=', $option->evaluation_id)->first();

        $analysis = Analysis::where('id','=',$evaluation->model_id)->first();

        return view($this->_path. 'add-option', [
            'preview' => true,
            'option' => $option,
            'analysis' => $analysis,
            'groups' => Keyword::getIt('evaluation__groups')->prepend('Odaberite grupu', ''),
            'types' => Keyword::getItByVal('evaluation__question_type'),
            'evaluation' => $evaluation
        ]);
    }

    public function editOption($id): View{
        $option   = EvaluationOption::where('id', '=', $id)->first();
        $evaluation = Evaluation::where('id', '=', $option->evaluation_id)->first();

        $analysis = Analysis::where('id','=',$evaluation->model_id)->first();

        return view($this->_path. 'add-option', [
            'edit' => true,
            'option' => $option,
            'analysis' => $analysis,
            'groups' => Keyword::getIt('evaluation__groups')->prepend('Odaberite grupu', ''),
            'types' => Keyword::getItByVal('evaluation__question_type')
        ]);
    }

    public function updateOption(Request $request): JsonResponse{
        try{
            EvaluationOption::where('id', '=', $request->id)->update([
                'group_by' => $request->group_by,
                'type' => $request->type,
                'question' => $request->question,
                'description' => $request->description
            ]);

            return $this->jsonSuccess(__('Uspješno spašeno'), route('system.admin.other.analysis.submodules.evaluations.preview', ['analysis_id' => $request->analysis_id]));

        }catch (\Exception $e){
            return $this->jsonError('5250', __('Desila se greška. Molimo kontaktirajte administratora'));
        }
    }
    public function deleteOption($id): RedirectResponse{
        try{
            $option   = EvaluationOption::where('id', '=', $id)->first();
            $evaluation = Evaluation::where('id', '=', $option->evaluation_id)->first();

            $instance = Instance::where('id','=',$evaluation->model_id)->first();
            $option->delete();

            return redirect()->route('system.admin.trainings.instances.submodules.evaluations.preview', ['instance_id' => $instance->id]);

        }catch (\Exception $e){
            return back()->with('error', __('Desila se greška. Molimo kontaktirajte administratora'));
        }
    }

    /**
     * Lock questionnaire (evaluation) and notify all users that are submitted to this training
     *
     * @param $instance_id
     * @return RedirectResponse
     */
    public function lock($instance_id): RedirectResponse{
        try{
            $evaluation = $this->checkForEvaluation($instance_id);

            /* Get instance information */
            $instance = Instance::where('id', '=', $instance_id)->first();
            $applicants = InstanceApp::where('instance_id', '=', $instance_id)->where('status', '=', 2)->get();

            foreach ($applicants as $applicant){
                try{
                    $this->createNotification($applicant->userRel, 'evaluation_published', Auth()->user()->id, 'Objavljena je evaluacija za obuku "' . ($instance->trainingRel->title ?? '') . '".', 'Obavijest o evaluaciji obuke', route('system.user-data.trainings.preview', ['id' => $instance->id ]));

                    if(isset($applicant->userRel)){
                        Mail::to($applicant->userRel->email)->send(new NotifyApplicants($applicant->userRel->gender, $applicant->userRel->name, $instance_id, $instance->trainingRel->title));
                    }
                }catch (\Exception $e){}
            }

            /**
             *  Mark evaluation as locked; No further changes can be done
             */
            $evaluation->update(['locked' => 1]);
            return back()->with('success', __('Evaluacija uspješno zaključana!'));
        }catch (\Exception $e){ return back()->with('error', __('Greška prilikom obrade podataka!')); }
    }
}
