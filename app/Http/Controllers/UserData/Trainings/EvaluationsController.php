<?php

namespace App\Http\Controllers\UserData\Trainings;

use App\Http\Controllers\Controller;
use App\Models\Trainings\Evaluations\Evaluation;
use App\Models\Trainings\Evaluations\EvaluationAnswer;
use App\Models\Trainings\Evaluations\EvaluationOption;
use App\Models\Trainings\Evaluations\EvaluationStatus;
use App\Models\Trainings\Instances\InstanceApp;
use App\Traits\Http\ResponseTrait;
use App\Traits\Users\UserBaseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluationsController extends Controller{
    use ResponseTrait, UserBaseTrait;

    /**
     * Submit answer to evaluation question
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function submit(Request $request): JsonResponse{
        try{
            $evaluation = Evaluation::where('id', '=', $request->evaluation_id)->first();
            if($evaluation->locked == 0) return $this->jsonError('3061', __('Evaluacija još nije dostupna! '));

            $status = EvaluationStatus::where('evaluation_id', '=', $request->evaluation_id)->where('user_id', '=', Auth::user()->id)->first();
            if($status) return $this->jsonError('3062', __('Evaluacija je poslana. Nije moguće naknadno uređivanje!'));


            $answer = EvaluationAnswer::where('evaluation_id', '=', $request->evaluation_id)
                ->where('option_id', '=', $request->option_id)
                ->where('user_id', '=', Auth::user()->id)
                ->first();

            if(!$answer){
                $application = InstanceApp::where('instance_id', '=', $evaluation->model_id)->where('user_id', '=', Auth::user()->id)->first();

                EvaluationAnswer::create([
                    'evaluation_id' => $request->evaluation_id,
                    'option_id' => $request->option_id,
                    'user_id' => Auth::user()->id,
                    'application_id' => $application->id,
                    'answer' => $request->answer,
                ]);
            }else{
                $answer->update(['answer' => $request->answer]);
            }

            return $this->apiResponse('0000', __('Uspješno spašeno'));
        }catch (\Exception $e){
            return $this->jsonError('3060', __('Greška prilikom procesiranja podataka. Molimo da nas kontaktirate!'));
        }
    }

    public function save(Request $request): JsonResponse{
        try{
            $options = EvaluationOption::where('evaluation_id', '=', $request->evaluation_id)->get();

            /** Get application ID */
            $evaluation = Evaluation::where('id', '=', $request->evaluation_id)->first();
            $application = InstanceApp::where('instance_id', '=', $evaluation->model_id)->where('user_id', '=', Auth::user()->id)->first();

            foreach ($options as $option){
                $answer = EvaluationAnswer::where('evaluation_id', '=', $request->evaluation_id)
                    ->where('option_id', '=', $option->id)
                    ->where('user_id', '=', Auth::user()->id)
                    ->first();

                if(!$answer){
                    EvaluationAnswer::create([
                        'evaluation_id' => $request->evaluation_id,
                        'option_id' => $option->id,
                        'user_id' => Auth::user()->id,
                        'application_id' => $application->id,
                        'answer' => ($option->type == 'with_answers') ? '0' : ''
                    ]);
                }
            }

            /**
             *  Create submit status
             */
            EvaluationStatus::create([
                'evaluation_id' => $request->evaluation_id,
                'user_id' => Auth::user()->id,
                'application_id' => $application->id
            ]);

            /** ToDo:: Notify user about submitted evaluation */

            /** ToDo:: Increase number of submissions in evaluations */

            return $this->apiResponse('0000', __('Evaluacija uspješno spašena!'));
        }catch (\Exception $e){
            return $this->jsonError('3060', __('Greška prilikom procesiranja podataka. Molimo da nas kontaktirate!'));
        }
    }
}
