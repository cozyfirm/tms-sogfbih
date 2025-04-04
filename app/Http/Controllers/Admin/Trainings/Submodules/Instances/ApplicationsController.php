<?php

namespace App\Http\Controllers\Admin\Trainings\Submodules\Instances;

use App\Http\Controllers\Admin\Core\Filters;
use App\Http\Controllers\Controller;
use App\Models\Core\File;
use App\Models\Core\Keyword;
use App\Models\Trainings\Instances\Instance;
use App\Models\Trainings\Instances\InstanceApp;
use App\Models\User;
use App\Traits\Common\CommonTrait;
use App\Traits\Http\ResponseTrait;
use App\Traits\Trainings\InstanceTrait;
use App\Traits\Users\UserBaseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ApplicationsController extends Controller{
    use ResponseTrait, CommonTrait, UserBaseTrait, InstanceTrait;

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

    public function downloadCertificate($id): mixed{
        try{
            $application = InstanceApp::where('id', '=', $id)->first();
            if($application->presence){
                $file = File::where('id', '=', $application->certificate_id)->first();

                return response()->download(storage_path('files/trainings/instances/certificates/user-certificates/' . $file->name), $file->file);
            }else return back();
        }catch (\Exception $e){
            return back();
        }
    }

    /**
     * Add application by admin
     *
     * @param $instance_id
     * @return View
     */
    public function addApplication($instance_id): View{
        return view($this->_path . 'add-application', [
            'instance' => Instance::where('id', '=', $instance_id)->first(),
            'users' => User::pluck('name', 'id')->prepend('Odaberite korisnika', '')
        ]);
    }

    public function saveApplication(Request $request): JsonResponse{
        try{
            $application = InstanceApp::where('instance_id', '=', $request->instance_id)
                ->where('user_id', '=', $request->user_id)
                ->first();

            if(!$application){
                $application = InstanceApp::create([
                    'instance_id' => $request->instance_id,
                    'user_id' => $request->user_id,
                    'date' => date('Y-m-d'),
                    'presence' => $request->presence,
                    'status' => 2
                ]);
            }else{
                $user = User::where('id', '=', $request->user_id)->first();

                return $this->jsonError('5250', $user->name . ' je već ' . (($user->gender == "1") ? 'prijavljen' : 'prijavljena') . ' na ovu obuku!');
            }
            if($request->certificate == "1"){
                $this->generateCertificate($application->id);
            }

            /**
             *  Update statistics about this instance
             */
            $this->updateStatistics($request->instance_id);

            if(isset($request->repeat)){
                return $this->apiResponse('0000', __('Uspješno ažurirano'));
            }else{
                return $this->jsonSuccess(__('Uspješno ste ažurirali podatke!'), route('system.admin.trainings.instances.preview', ['id' => $request->instance_id ]));
            }
        }catch (\Exception $e){
            return $this->jsonError('5250', __('Desila se greška. Molimo kontaktirajte administratora'));
        }
    }
}
