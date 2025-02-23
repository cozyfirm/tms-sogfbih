<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\Trainings\Instances\Instance;
use App\Models\Trainings\Instances\InstanceApp;
use App\Models\Users\Notification;
use App\Traits\Http\ResponseTrait;
use App\Traits\Users\UserBaseTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller{
    use ResponseTrait, UserBaseTrait;

    /**
     * Reset number of notifications
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function reset(Request $request): JsonResponse{
        try{
            Auth::user()->update([ 'notifications' => 0 ]);

            return $this->apiResponse('0000', __('Successfully reset notifications.'), [
                'total' => 0
            ]);
        }catch (\Exception $e){
            return $this->jsonError('5000', __('Greška prilikom procesiranja podataka. Molimo da nas kontaktirate!'));
        }
    }

    /**
     * Mark notification as read
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function markAsRead(Request $request): JsonResponse{
        try{
            $notification = Notification::where('id', '=', $request->id)->first();
            if($notification->user_id == Auth::user()->id){
                $notification->update([ 'read' => true ]);
            }

            return $this->apiResponse('0000', __('Success'));
        }catch (\Exception $e){
            return $this->jsonError('5000', __('Greška prilikom procesiranja podataka. Molimo da nas kontaktirate!'));
        }
    }
}
