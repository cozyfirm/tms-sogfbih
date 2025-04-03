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
use App\Traits\Trainings\InstanceTrait;
use App\Traits\Users\UserBaseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use PhpOffice\PhpWord\TemplateProcessor;

class PresenceController extends Controller{
    use ResponseTrait, CommonTrait, UserBaseTrait, InstanceTrait;
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
            if($this->checkForPresence($application->id)){
                $application->update([ 'presence' => '1' ]);
            }else{
                $application->update([ 'presence' => '0' ]);
            }

            return $this->apiResponse('0000', __('Uspješno ažurirano'));
        }catch (\Exception $e){
            return $this->jsonError('5250', __('Desila se greška. Molimo kontaktirajte administratora'));
        }
    }
}
