<?php

namespace App\Http\Controllers\Admin\Trainings\Submodules\Instances;

use App\Http\Controllers\Controller;
use App\Models\Trainings\Instances\InstanceTrainer;
use App\Traits\Common\CommonTrait;
use App\Traits\Http\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TrainersController extends Controller{
    use ResponseTrait, CommonTrait;

    /**
     * Save trainer to training instance
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function save(Request $request): JsonResponse{
        try{
            /** ToDo: Validation for grade */
            if($request->grade < 0 or $request->grade > 10){
                return $this->jsonError('5101', __('Format ocjene nije validan!'));
            }
            if($request->contract < 0 or $request->contract > 10000){
                return $this->jsonError('5102', __('Vrijednost ugovora nije validna'));
            }

            $request['grade'] = $this->roundNumber($request->grade, 1);
            $request['contract'] = $this->roundNumber($request->contract, 2);

            if(isset($request->activeTrainer)){
                /** Update trainer by ID */
                InstanceTrainer::where('instance_id', '=', $request->instance_id)->where('trainer_id', '=', $request->trainer_id)->update(['instance_id' => $request->instance_id, 'trainer_id' => $request->trainer_id, 'grade' => $request->grade, 'contract' => $request->contract, 'monitoring' => $request->monitoring]);
            }else{
                /** Add trainer to instance */
                $rel = InstanceTrainer::where('instance_id', '=', $request->instance_id)->where('trainer_id', '=', $request->trainer_id)->first();
                if(!$rel){
                    InstanceTrainer::create(['instance_id' => $request->instance_id, 'trainer_id' => $request->trainer_id, 'grade' => $request->grade, 'contract' => $request->contract, 'monitoring' => $request->monitoring]);
                }else{
                    return $this->jsonError('5103', __('Trener već dodan na obuku!'));
                }
            }

            return $this->jsonSuccess(__('Uspješno ažurirano'), route('system.admin.trainings.instances.preview', ['id' => $request->instance_id]));

        }catch (\Exception $e){
            dd($e);
            return $this->jsonError('5100', __('Desila se greška. Molimo kontaktirajte administratora'));
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
            return $this->apiResponse('0000', __('Success'), [
                'rel' => InstanceTrainer::where('instance_id', '=', $request->instance_id)->where('trainer_id', '=', $request->trainer_id)->first()
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
            InstanceTrainer::where('instance_id', '=', $request->instance_id)->where('trainer_id', '=', $request->trainer_id)->delete();

            return $this->jsonSuccess(__('Uspješno ažurirano'), route('system.admin.trainings.instances.preview', ['id' => $request->instance_id]));
        }catch (\Exception $e){
            return $this->jsonError('5100', __('Desila se greška. Molimo kontaktirajte administratora'));
        }
    }
}
