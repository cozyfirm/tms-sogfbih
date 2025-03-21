<?php

namespace App\Http\Controllers\Admin\Other\Analysis;

use App\Http\Controllers\Controller;
use App\Mail\Evaluations\NotifyCreator;
use App\Models\Other\Analysis\Analysis;
use App\Models\Other\Analysis\EvaluationAnalysis;
use App\Models\Other\Analysis\EvaluationAnalyticsAnswer;
use App\Models\Trainings\Evaluations\Evaluation;
use App\Models\Trainings\Evaluations\EvaluationAnswer;
use App\Models\Trainings\Evaluations\EvaluationOption;
use App\Models\Trainings\Evaluations\EvaluationStatus;
use App\Models\Trainings\Instances\Instance;
use App\Models\Trainings\Instances\InstanceApp;
use App\Traits\Common\CommonTrait;
use App\Traits\Http\ResponseTrait;
use App\Traits\Users\UserBaseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class SubmissionController extends Controller{
    use ResponseTrait, CommonTrait, UserBaseTrait;

    protected string $_path = 'admin.app.other.analysis.submodules.public-data.';

    /**
     * Create and submit questionnaire by user
     * @param $hash
     * @return View
     */
    public function index($hash): View | RedirectResponse{
        if(!Auth::check()){
            /** User is not logged in; Put link into session */
            Session::put('getBackToUri', url()->full());
            /** Redirect to auth */
            return redirect()->route('auth');
        }
        $analysis = Analysis::where('hash', '=', $hash)->first();

        $evaluation = Evaluation::where('type', '=','__analysis')->where('model_id', '=', $analysis->id)->first();
        if(!$evaluation){
            abort(404);
        }

        if($analysis->date_from > date('Y-m-d') or $analysis->date_to < date('Y-m-d')) abort(404);

        /**
         *  If there is no created submissions, create one
         */
        $evaluationAnalysis = EvaluationAnalysis::where('session_id', '=', request()->session()->getId())->first();
        if(!$evaluationAnalysis){
            $evaluationAnalysis = EvaluationAnalysis::create([
                'evaluation_id' => $evaluation->id,
                'user_id' => Auth::user()->id,
                'session_id' =>  request()->session()->getId(),
                'ip_addr' => request()->ip()
            ]);
        }

        $groups = EvaluationOption::where('evaluation_id', '=', $evaluation->id)->orderBy('group_by')->get()->unique('group_by');

        /**
         *  Update number of views
         */
        $analysis->update(['views' => EvaluationAnalysis::where('evaluation_id', '=', $evaluation->id)->count()]);

        return view($this->_path . 'index', [
            'analysis' => $analysis,
            'evaluation' => $evaluation,
            'groups' => $groups ?? [],
            'evaluationAnalysis' => $evaluationAnalysis
        ]);
    }

    /**
     * Preview by admins
     * @param $hash
     * @param $id
     * @return View
     */
    public function preview($hash, $id): View{
        $analysis = Analysis::where('hash', '=', $hash)->first();
        $evaluation = Evaluation::where('type', '=','__analysis')->where('model_id', '=', $analysis->id)->first();

        /**
         *  If there is no created submissions, create one
         */
        $evaluationAnalysis = EvaluationAnalysis::where('id', '=', $id)->first();
        $groups             = EvaluationOption::where('evaluation_id', '=', $evaluation->id)->orderBy('group_by')->get()->unique('group_by');

        return view($this->_path . 'index', [
            'analysis' => $analysis,
            'evaluation' => $evaluation,
            'groups' => $groups ?? [],
            'evaluationAnalysis' => $evaluationAnalysis,
            'preview' => true
        ]);
    }

    /**
     * Submit answer to evaluation question
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function submit(Request $request): JsonResponse{
        try{
            $evaluation = Evaluation::where('id', '=', $request->evaluation_id)->first();
            if($evaluation->locked == 0) return $this->jsonError('5001', __('Anketa još nije dostupna! '));

            $status = EvaluationAnalysis::where('evaluation_id', '=', $request->evaluation_id)->where('session_id', '=', $request->session()->getId())->first();
            if($status->status == 'submitted') return $this->jsonError('5002', __('Anketa je završena. Nije moguće naknadno uređivanje!'));


            $answer = EvaluationAnalyticsAnswer::where('evaluation_id', '=', $request->evaluation_id)
                ->where('option_id', '=', $request->option_id)
                ->where('analytics_id', '=', $status->id)
                ->first();

            if(!$answer){
                EvaluationAnalyticsAnswer::create([
                    'evaluation_id' => $request->evaluation_id,
                    'option_id' => $request->option_id,
                    'analytics_id' => $status->id,
                    'answer' => $request->answer,
                ]);
            }else{
                $answer->update(['answer' => $request->answer]);
            }

            return $this->apiResponse('0000', __('Uspješno spašeno'));
        }catch (\Exception $e){
            return $this->jsonError('5000', __('Greška prilikom procesiranja podataka. Molimo da nas kontaktirate!'));
        }
    }

    public function save(Request $request): JsonResponse{
        try{
            $options = EvaluationOption::where('evaluation_id', '=', $request->evaluation_id)->get();

            /** Get application ID */
            $evaluation = Evaluation::where('id', '=', $request->evaluation_id)->first();
            $analysis   = Analysis::where('id', '=', $evaluation->model_id)->first();

            $status = EvaluationAnalysis::where('evaluation_id', '=', $request->evaluation_id)->where('session_id', '=', $request->session()->getId())->first();

            if($status->status != 'submitted'){
                foreach ($options as $option){
                    $answer = EvaluationAnalyticsAnswer::where('evaluation_id', '=', $request->evaluation_id)
                        ->where('option_id', '=', $option->id)
                        ->where('analytics_id', '=', $status->id)
                        ->first();

                    if(!$answer){
                        EvaluationAnalyticsAnswer::create([
                            'evaluation_id' => $request->evaluation_id,
                            'option_id' => $option->id,
                            'analytics_id' => $status->id,
                            'answer' => ($option->type == 'with_answers') ? '0' : ''
                        ]);
                    }
                }

                $status->update(['status' => 'submitted']);
            }

            /**
             *  Create submit status
             */
//            EvaluationStatus::create([
//                'evaluation_id' => $request->evaluation_id,
//                'user_id' => Auth::user()->id,
//                'application_id' => $application->id
//            ]);

            try{
                /**
                 * Create notification
                 */
                // $this->createNotification($analysis->createdBy, 'analysis_submitted', Auth()->user()->id,  (Auth::user()->name ) . ' je ' . ((Auth::user()->gender == 1) ? 'završio' : 'završila') . ' evaluaciju za "' . ($instance->trainingRel->title ?? '') . '".', 'Obavijest o evaluaciji obuke', route('system.admin.trainings.instances.preview', ['id' => $instance->id ]));

                /**
                 *  ToDo:: Send an email
                 */
                // Mail::to($instance->createdBy->email)->send(new NotifyCreator(Auth::user()->gender, Auth::user()->name, $instance->id, $instance->trainingRel->title));
            }catch (\Exception $e){}

            $totalSubmitted = EvaluationAnalysis::where('evaluation_id', '=', $request->evaluation_id)->where('status', '=', 'submitted')->count();
            /** Increase number of submitted questionnaires in Evaluation */
            $evaluation->update(['submissions' => $totalSubmitted]);
            /** Increase number of submitted questionnaires in analysis */
            $analysis->update(['submissions' => $totalSubmitted]);

            return $this->apiResponse('0000', __('Anketa uspješno spašena!'));
        }catch (\Exception $e){
            return $this->jsonError('5000', __('Greška prilikom procesiranja podataka. Molimo da nas kontaktirate!'));
        }
    }
}
