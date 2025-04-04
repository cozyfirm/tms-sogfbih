<?php

namespace App\Http\Controllers\UserData\Trainings;

use App\Http\Controllers\Controller;
use App\Mail\Evaluations\NotifyApplicants;
use App\Mail\Evaluations\NotifyCreator;
use App\Models\Trainings\Evaluations\Evaluation;
use App\Models\Trainings\Evaluations\EvaluationAnswer;
use App\Models\Trainings\Evaluations\EvaluationOption;
use App\Models\Trainings\Evaluations\EvaluationStatus;
use App\Models\Trainings\Instances\Instance;
use App\Models\Trainings\Instances\InstanceApp;
use App\Traits\Http\ResponseTrait;
use App\Traits\Trainings\InstanceTrait;
use App\Traits\Users\UserBaseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EvaluationsController extends Controller{
    use ResponseTrait, UserBaseTrait, InstanceTrait;

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

            $instance = Instance::where('id', '=', $evaluation->model_id)->first();

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

            /** Check if was present */
            if($this->checkForPresence($application->id)){
                /** Generate certificate */
                if($this->generateCertificate($application->id)){
                    /** Create notification to user that certificate is generated */
                    $this->createNotification($application->userRel, 'cert_generated', Auth()->user()->id, 'Vaš certifikat za obuku "' . ($instance->trainingRel->title ?? '') . '" je generisan!', 'Obavijest o generisanju certifikata', route('system.user-data.trainings.apis.applications.download-certificate', ['application_id' => $application->id]));
                }
            }else{
                $application->update([
                    'presence' => '0',
                    'certificate_id' => null
                ]);
            }

            try{
                /**
                 * Create notification to instance creator
                 */
                $this->createNotification($instance->createdBy, 'evaluation_submitted', Auth()->user()->id,  (Auth::user()->name ) . ' je ' . ((Auth::user()->gender == 1) ? 'završio' : 'završila') . ' evaluaciju za "' . ($instance->trainingRel->title ?? '') . '".', 'Obavijest o evaluaciji obuke', route('system.admin.trainings.instances.preview', ['id' => $instance->id ]));

                /**
                 *  Send an email
                 */
                Mail::to($instance->createdBy->email)->send(new NotifyCreator(Auth::user()->gender, Auth::user()->name, $instance->id, $instance->trainingRel->title));
            }catch (\Exception $e){}

            /** ToDo:: Increase number of submissions in evaluations */
            $evaluation->update(['submissions' => EvaluationStatus::where('evaluation_id', '=', $request->evaluation_id)->count()]);

            return $this->apiResponse('0000', __('Evaluacija uspješno spašena!'));
        }catch (\Exception $e){
            return $this->jsonError('3060', __('Greška prilikom procesiranja podataka. Molimo da nas kontaktirate!'));
        }
    }
}
