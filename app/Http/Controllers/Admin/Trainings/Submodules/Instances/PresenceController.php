<?php

namespace App\Http\Controllers\Admin\Trainings\Submodules\Instances;

use App\Http\Controllers\Admin\Core\Filters;
use App\Http\Controllers\Controller;
use App\Models\Core\File;
use App\Models\Core\Keyword;
use App\Models\Trainings\Instances\Instance;
use App\Models\Trainings\Instances\InstanceApp;
use App\Models\Trainings\Instances\InstanceEvent;
use App\Models\Trainings\Instances\InstancePresence;
use App\Models\User;
use App\Traits\Common\CommonTrait;
use App\Traits\Http\ResponseTrait;
use App\Traits\Users\UserBaseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use PhpOffice\PhpWord\TemplateProcessor;

class PresenceController extends Controller{
    use ResponseTrait, CommonTrait, UserBaseTrait;

    protected int $_success = 70;
    protected string $_path = 'admin.app.trainings.instances.submodules.presence.';

    public function index($instance_id): View{
        $applications = InstanceApp::where('instance_id', '=', $instance_id)->orderBy('id', 'DESC')->get();
        $dates = InstanceEvent::where('instance_id', '=', $instance_id)->get()->unique('date');

        return view($this->_path . 'index', [
            'applications' => $applications,
            'instance' => Instance::where('id', '=', $instance_id)->first(),
            'dates' => $dates
        ]);
    }

    /**
     * Check does user satisfied limit for certificate generation
     *
     * @param $application_id
     * @return bool
     */
    protected function checkForPresence($application_id): bool{
        try{
            $application = InstanceApp::where('id', '=', $application_id)->first();
            $totalDays   = $application->instanceRel->totalDays();

            $present = InstancePresence::where('application_id', '=', $application_id)->count();

            return ((($present / $totalDays) * 100) > $this->_success);
        }catch (\Exception $e){
            return false;
        }
    }

    /**
     * Generate docx certificate for training
     *
     * @param $application_id
     * @return mixed
     */
    public function generateCertificate($application_id): mixed{
        try{
            $templateProcessor = new TemplateProcessor(storage_path('files/trainings/instances/certificates/certificate.docx'));
            $application = InstanceApp::where('id', '=', $application_id)->first();
            $instance    = Instance::where('id', '=', $application->instance_id)->first();

            $templateProcessor->setValue('date', date('d.m.Y'));
            $templateProcessor->setValue('number', date($application_id));
            $templateProcessor->setValue('year', date('Y'));

            $templateProcessor->setValue('name', $application->userRel->name ?? '');
            $templateProcessor->setValue('training', $instance->trainingRel->title ?? '');
            $templateProcessor->setValue('training_date', $instance->startDate() ?? '');
            $templateProcessor->setValue('place', "Mjesto održavanja obuke");

            if($application->userRel->gender == 1){
                $templateProcessor->setValue('present', "prisustvovao");
            }else{
                $templateProcessor->setValue('present', "prisustvovala");
            }

            /** @var $userName; Extract for username */
            $userName = str_replace('-', '_', strtolower($application->userRel->username ?? ''));

            $fileName = $userName . date('_d_m_y'). '.docx';
            $templateProcessor->saveAs(storage_path('files/trainings/instances/certificates/user-certificates/' . $fileName));

            /** Create file and certificate name */
            $file = File::create([
                'file' => ($application->userRel->name ?? '') . ' - ' . ($instance->trainingRel->title ?? '') . '.docx',
                'name' => $fileName,
                'ext' => 'docx',
                'type' => 'certificate',
                'path' => 'files/trainings/instances/certificates/user-certificates/'
            ]);

            $application->update([
                'presence' => 1,
                'certificate_id' => $file->id
            ]);

            return true;
        }catch (\Exception $e){
            return false;
        }
    }

    /**
     * Update presence by dates
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updatePresence(Request $request): JsonResponse{
        try{
            $presence = InstancePresence::where('application_id', '=', $request->id)->where('date', '=', $request->date)->first();

            if($presence){
                $presence->delete();
            }else{
                InstancePresence::create([
                    'application_id' => $request->id,
                    'date' => $request->date
                ]);
            }

            $application = InstanceApp::where('id', '=', $request->id)->first();
            $instance = Instance::where('id', '=', $application->instance_id)->first();

            /** Check for certificate */
            if($this->checkForPresence($request->id)){
                if($this->generateCertificate($request->id)){
                    /** ToDo :: Generate notification */
                    $this->createNotification($application->userRel, 'cert_generated', Auth()->user()->id, 'Vaš certifikat za obuku "' . ($instance->trainingRel->title ?? '') . '" je generisan!', 'Obavijest i generisanju certifikata', "#");

                    return $this->apiResponse('0000', __('Uspješno ažurirano. Certifikat generisan!'));
                }
            }else{
                $application->update([
                    'presence' => '0',
                    'certificate_id' => null
                ]);
            }

            return $this->apiResponse('0000', __('Uspješno ažurirano'));
        }catch (\Exception $e){
            return $this->jsonError('5250', __('Desila se greška. Molimo kontaktirajte administratora'));
        }
    }
}
