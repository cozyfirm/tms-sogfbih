<?php

namespace App\Http\Controllers\Admin\Other;

use App\Http\Controllers\Controller;
use App\Models\Other\Bodies\Bodies;
use App\Models\Other\InternalEvents\InternalEvent;
use App\Models\Other\Participant;
use App\Models\Trainings\Instances\InstanceTrainer;
use App\Traits\Common\CommonTrait;
use App\Traits\Http\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ParticipantsController extends Controller{
    use ResponseTrait, CommonTrait;

    /**
     * Update statistics
     *
     * @param $type
     * @param $modelID
     * @return void
     */
    protected function totalParticipants($type, $modelID): void{
        try{
            if($type == 'ie'){
                InternalEvent::where('id', '=', $modelID)->update(['participants' => Participant::where('model_id', '=', $modelID)->where('type', '=', $type)->count()]);
            }else{
                Bodies::where('id', '=', $modelID)->update(['participants' => Participant::where('model_id', '=', $modelID)->where('type', '=', $type)->count()]);
            }
        }catch (\Exception $e){}
    }

    /**
     * Save participant
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function save(Request $request): JsonResponse{
        try{
            $participant = Participant::create([
                'type' => $request->type,
                'model_id' => $request->model_id,
                'name' => $request->name
            ]);

            /** Update statistics */
            $this->totalParticipants($request->type, $request->model_id);

            return $this->apiResponse('0000', __('Uspješno spašeno'), [
                'participant' => $participant->toArray()
            ]);
        }catch (\Exception $e){
            return $this->jsonError('5100', __('Desila se greška. Molimo kontaktirajte administratora'));
        }
    }

    /**
     * Fetch data for participant
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function fetch(Request $request): JsonResponse{
        try{
            return $this->apiResponse('0000', __('Success'), [
                'participant' => Participant::where('id', '=', $request->id)->first()
            ]);
        }catch (\Exception $e){
            return $this->jsonError('5100', __('Desila se greška. Molimo kontaktirajte administratora'));
        }
    }

    /**
     * Update participant name
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse{
        try{
            Participant::where('id', '=', $request->id)->update([
                'name' => $request->name
            ]);

            return $this->apiResponse('0000', __('Uspješno spašeno'), [
                'participant' => Participant::where('id', '=', $request->id)->first()->toArray()
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
            $participant = Participant::where('id', '=', $request->id)->first();

            /** Store data */
            $type = $participant->type;
            $modelID = $participant->model_id;
            $name = $participant->name;

            /** Delete participant */
            $participant->delete();

            /** Update statistics */
            $this->totalParticipants($type, $modelID);

            return $this->apiResponse('0000', __('Uspješno obrisan učesnik/ca ' . $name));
        }catch (\Exception $e){
            return $this->jsonError('5100', __('Desila se greška. Molimo kontaktirajte administratora'));
        }
    }
}
