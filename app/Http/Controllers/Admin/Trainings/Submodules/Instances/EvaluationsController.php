<?php

namespace App\Http\Controllers\Admin\Trainings\Submodules\Instances;

use App\Http\Controllers\Admin\Core\Filters;
use App\Http\Controllers\Controller;
use App\Models\Core\Keyword;
use App\Models\Trainings\Evaluations\Evaluation;
use App\Models\Trainings\Evaluations\EvaluationOption;
use App\Models\Trainings\Instances\Instance;
use App\Traits\Common\CommonTrait;
use App\Traits\Http\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EvaluationsController extends Controller{
    use ResponseTrait, CommonTrait;

    protected string $_path = 'admin.app.trainings.instances.submodules.evaluations.';

    public function preview($instance_id): View{
        $instance = Instance::where('id','=',$instance_id)->first();
        $options  = EvaluationOption::whereHas('evaluationRel', function ($q) use($instance){
            $q->where('model_id','=',$instance->id)->where('type', '=', '__training');
        })->orderBy('group_by');

        $options = Filters::filter($options);

        $filters = [
            'groupRel.name' => 'Grupa pitanja',
            'typeRel.name' => __('Vrsta pitanja'),
            'question' => __('Pitanje'),
            'description' => __('Opis pitanja')
        ];

        return view($this->_path. 'preview',[
            'instance' => $instance,
            'filters' => $filters,
            'options' => $options
        ]);
    }

    public function addOption($instance_id): View{
        $instance = Instance::where('id','=',$instance_id)->first();

        return view($this->_path. 'add-option', [
            'create' => true,
            'instance' => $instance,
            'groups' => Keyword::getIt('evaluation__groups')->prepend('Odaberite grupu', ''),
            'types' => Keyword::getItByVal('evaluation__question_type')
        ]);
    }

    public function checkForEvaluation($instance_id){
        try{
            $evaluation = Evaluation::where('type', '=', '__training')->where('model_id', '=', $instance_id)->first();
            if(!$evaluation){
                $evaluation = Evaluation::create([
                    'type' => '__training',
                    'model_id' => $instance_id
                ]);
            }

            return $evaluation;
        }catch (\Exception $e){
            return false;
        }
    }

    public function saveOption(Request $request): JsonResponse{
        try{

            $evaluation = $this->checkForEvaluation($request->instance_id);
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
                    return $this->jsonSuccess(__('Uspješno spašeno'), route('system.admin.trainings.instances.submodules.evaluations.add-option', ['instance_id' => $request->instance_id]));
                }else{
                    return $this->jsonSuccess(__('Uspješno spašeno'), route('system.admin.trainings.instances.submodules.evaluations.preview', ['instance_id' => $request->instance_id]));
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

        $instance = Instance::where('id','=',$evaluation->model_id)->first();

        return view($this->_path. 'add-option', [
            'preview' => true,
            'option' => $option,
            'instance' => $instance,
            'groups' => Keyword::getIt('evaluation__groups')->prepend('Odaberite grupu', ''),
            'types' => Keyword::getItByVal('evaluation__question_type')
        ]);
    }

    public function editOption($id): View{
        $option   = EvaluationOption::where('id', '=', $id)->first();
        $evaluation = Evaluation::where('id', '=', $option->evaluation_id)->first();

        $instance = Instance::where('id','=',$evaluation->model_id)->first();

        return view($this->_path. 'add-option', [
            'edit' => true,
            'option' => $option,
            'instance' => $instance,
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

            return $this->jsonSuccess(__('Uspješno spašeno'), route('system.admin.trainings.instances.submodules.evaluations.preview-option', ['id' => $request->id ]));

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
}
