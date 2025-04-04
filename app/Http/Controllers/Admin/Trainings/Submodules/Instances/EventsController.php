<?php

namespace App\Http\Controllers\Admin\Trainings\Submodules\Instances;

use App\Http\Controllers\Controller;
use App\Models\Trainings\Instances\InstanceEvent;
use App\Traits\Common\CommonTrait;
use App\Traits\Http\ResponseTrait;
use App\Traits\Trainings\InstanceTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventsController extends Controller{
    use ResponseTrait, CommonTrait, InstanceTrait;

    public function save(Request $request): JsonResponse{
        try{
            $request['date'] = Carbon::parse($request->date)->format('Y-m-d');
            $request['tf__dt'] = Carbon::parse($request->date . ' ' . $request->tf)->format('Y-m-d H:i:s');

            if(isset($request->activeEvent)){
                /** Update event */
                InstanceEvent::where('id', '=', $request->activeEvent)->update($request->except(['instance_id', 'activeEvent']));
            }else{
                /** Add event */
                /* ToDo:: Add additional check */
                InstanceEvent::create($request->except(['_token', 'activeEvent']));
            }

            /** Update start, end date and duration */
            $this->updateDuration($request->instance_id);

            return $this->jsonSuccess(__('Uspješno ažurirano'), route('system.admin.trainings.instances.preview', ['id' => $request->instance_id]));
        }catch (\Exception $e){
            return $this->jsonError('5150', __('Desila se greška. Molimo kontaktirajte administratora'));
        }
    }

    /**
     * Fetch data for trainer from instance -> trainer relationship
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function fetch(Request $request): JsonResponse{
        try{
            $event = InstanceEvent::where('id', '=', $request->id)->first();
            $event->_date = $event->date();

            return $this->apiResponse('0000', __('Success'), [
                'event' => $event
            ]);
        }catch (\Exception $e){
            return $this->jsonError('5100', __('Desila se greška. Molimo kontaktirajte administratora'));
        }
    }

    /**
     * Delete relationship data
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse{
        try{
            $event = InstanceEvent::where('id', '=', $request->id)->first();
            $instance_id = $event->instance_id;
            $event->delete();

            /** Update start, end date and duration */
            $this->updateDuration($instance_id);

            return $this->jsonSuccess(__('Uspješno obrisano'), route('system.admin.trainings.instances.preview', ['id' => $request->instance_id]));
        }catch (\Exception $e){
            return $this->jsonError('5100', __('Desila se greška. Molimo kontaktirajte administratora'));
        }
    }
}
