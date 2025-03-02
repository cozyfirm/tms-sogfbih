<?php

namespace App\Http\Controllers\UserData\Trainings;

use App\Http\Controllers\Controller;
use App\Mail\Applications\NotifyCreator;
use App\Mail\Users\ConfirmEmail;
use App\Models\Core\File;
use App\Models\Trainings\Instances\Instance;
use App\Models\Trainings\Instances\InstanceApp;
use App\Models\User;
use App\Traits\Http\ResponseTrait;
use App\Traits\Users\UserBaseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ApplicationsController extends Controller{
    use ResponseTrait, UserBaseTrait;

    /**
     * Create notification when user sign-ups
     *
     * @param Request $request
     * @param $instance
     * @param $what
     * @return void
     */
    public function createSignUpNotifications(Request $request, $instance, $what): void{
        try{
            $title = $instance->trainingRel->title ?? 'Unknown';

            /**
             *  Create notifications for user that created training instance
             *  Notify them that user signed for training
             */
            $createdBy = User::where('id', '=', $instance->created_by)->first();

            if($what == 'sign_up'){
                $this->createNotification($createdBy, $what, Auth()->user()->id, (Auth()->user()->name ?? 'John Doe') . ' se ' . ((Auth()->user()->gender == 1) ? 'prijavio' : 'prijavila') . ' na obuku. Više informacija', 'Obavijest o prijavi na obuku: ' . $title . ".", route('system.admin.trainings.instances.submodules.applications', ['instance_id' => $instance->id ]));
            }else{
                $this->createNotification($createdBy, $what, Auth()->user()->id, (Auth()->user()->name ?? 'John Doe') . ' se ' . ((Auth()->user()->gender == 1) ? 'odjavio' : 'odjavila') . ' sa obuke. Više informacija', 'Obavijest o odjavi sa obuke: ' . $title . ".", route('system.admin.trainings.instances.submodules.applications', ['instance_id' => $instance->id ]));
            }

            Mail::to($createdBy->email)->send(new NotifyCreator($what, Auth::user()->name, Auth::user()->gender, $instance->id, $instance->trainingRel->title));
        }catch (\Exception $e){ }
    }

    /**
     * Sign up for training
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function signUp(Request $request): JsonResponse{
        try{
            /** Let's first find an instance and check is everything fine */
            $instance = Instance::where('id', '=', $request->instanceID)->first();
            if($instance->application_date < date('Y-m-d')){
                return $this->jsonError('3051', __('Rok za prijavu na obuku je istekao!'));
            }

            /** @var $application */
            $application = InstanceApp::where('instance_id', '=', $request->instanceID)->where('user_id', '=', Auth::user()->id)->first();
            if(!$application){
                /** Ne postoji prijava, kreiraj prijavu */
                $application = InstanceApp::create([
                    'instance_id' => $request->instanceID,
                    'user_id' => Auth::user()->id,
                    'date' => date('Y-m-d')
                ]);

                /** Create notifications */
                $this->createSignUpNotifications($request, $instance, 'sign_up');

                return $this->apiResponse('0000', __('Uspješno ste se prijavili na obuku'), [
                    'subcode' => '0000-1',
                    'application' => $application
                ]);
            }else{
                InstanceApp::where('instance_id', '=', $request->instanceID)->where('user_id', '=', Auth::user()->id)->delete();

                /** Create notifications */
                $this->createSignUpNotifications($request, $instance, 'sign_out');

                return $this->apiResponse('0000', __('Uspješno ste se odjavili sa obuke'), [
                    'subcode' => '0000-2'
                ]);
            }
        }catch (\Exception $e){
            return $this->jsonError('3050', __('Greška prilikom procesiranja podataka. Molimo da nas kontaktirate!'));
        }
    }

    /**
     * Download certificate by user
     *
     * @param $id
     * @return mixed
     */
    public function downloadCertificate($id): mixed{
        try{
            $application = InstanceApp::where('id', '=', $id)->first();
            if($application->user_id != Auth::user()->id){
                return back();
            }

            if($application->presence){
                $file = File::where('id', '=', $application->certificate_id)->first();

                return response()->download(storage_path('files/trainings/instances/certificates/user-certificates/' . $file->name), $file->file);
            }else return back();
        }catch (\Exception $e){
            return back();
        }
    }
}
