<?php

namespace App\Http\Controllers\Admin\Trainings\Submodules\Instances;

use App\Http\Controllers\Admin\Core\Filters;
use App\Http\Controllers\Controller;
use App\Models\Core\Keyword;
use App\Models\Trainings\Instances\Instance;
use App\Models\Trainings\Instances\InstanceApp;
use App\Models\User;
use App\Traits\Common\CommonTrait;
use App\Traits\Http\ResponseTrait;
use App\Traits\Users\UserBaseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ApplicationsController extends Controller{
    use ResponseTrait, CommonTrait, UserBaseTrait;

    protected string $_path = 'admin.app.trainings.instances.submodules.applications.';

    public function index($instance_id): View{
        $applications = InstanceApp::where('instance_id', '=', $instance_id)->orderBy('id', 'DESC');
        $applications = Filters::filter($applications);

        $filters = [
            'userRel.name' => 'Ime i prezime',
            'date' => __('Datum prijave'),
            'statusRel.name' => __('Status prijave'),
            'certificate' => __('Certifikat')
        ];

        return view($this->_path . 'index', [
            'filters' => $filters,
            'applications' => $applications,
            'instance' => Instance::where('id', '=', $instance_id)->first(),
            'statuses' => Keyword::getItByVal('application_status')
        ]);
    }

    public function updateStatus(Request $request): JsonResponse{
        try{
            $application = InstanceApp::where('id', '=', $request->id)->first();
            $application->update([
                'status' => $request->status
            ]);

            $user = User::where('id', '=', $application->user_id)->first();
            $instance = Instance::where('id', '=', $application->instance_id)->first();

            /**
             *  Create notification for user
             */
            if($request->status == 2){
                /** Application accepted */

                $this->createNotification($user, 'app__accepted', Auth()->user()->id, 'Vaša prijava na obuku "' . ($instance->trainingRel->title ?? '') . '" je prihvaćena!', 'Obavijest o prijavi na obuku', route('system.user-data.trainings.preview', ['id' => $instance->id ]));
            }else if($request->status == 3){
                /** Application denied */

                $this->createNotification($user, 'app__denied', Auth()->user()->id, 'Vaša prijava na obuku "' . ($instance->trainingRel->title ?? '') . '" je odbijena!', 'Za više informacija, molimo da se obratite administratorima sistema!', route('system.user-data.trainings.preview', ['id' => $instance->id ]));
            }

            return $this->apiResponse('0000', __('Uspješno ažurirano'));
        }catch (\Exception $e){
            return $this->jsonError('5250', __('Desila se greška. Molimo kontaktirajte administratora'));
        }
    }
}
