<?php

namespace App\Http\Controllers\UserData\Trainings;

use App\Http\Controllers\Controller;
use App\Models\Trainings\Instances\Instance;
use App\Models\Trainings\Instances\InstanceApp;
use App\Models\User;
use App\Traits\Http\ResponseTrait;
use App\Traits\Users\UserBaseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationsController extends Controller{
    use ResponseTrait, UserBaseTrait;

    public function createSignUpNotifications(Request $request, $instance, $what): void{
        try{
            $title = $instance->trainingRel->title ?? 'Unknown';

            /**
             *  Create notifications for admins and moderators
             *  Notify them that user signed for training
             */
            $admins = User::whereIn('role', ['admin', 'moderator'])->get();
            foreach ($admins as $admin) {
                if($what == 'sign_up'){
                    $this->createNotification($admin, $what, Auth()->user()->id, (Auth()->user()->name ?? 'John Doe') . ' se ' . ((Auth()->user()->gender == 1) ? 'prijavio' : 'prijavila') . ' na obuku. Više informacija', 'Obavijest o prijavi na obuku: ' . $title . ".", "#");
                }else{
                    $this->createNotification($admin, $what, Auth()->user()->id, (Auth()->user()->name ?? 'John Doe') . ' se ' . ((Auth()->user()->gender == 1) ? 'odjavio' : 'odjavila') . ' sa obuke. Više informacija', 'Obavijest o odjavi sa obuke: ' . $title . ".", "#");
                }
            }
        }catch (\Exception $e){}
    }
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
}
