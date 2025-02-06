<?php

namespace App\Http\Controllers\Admin\Trainings\Submodules\Instances;

use App\Http\Controllers\Controller;
use App\Models\Trainings\Instances\InstanceTrainer;
use App\Models\Trainings\Submodules\Locations\Location;
use App\Traits\Common\CommonTrait;
use App\Traits\Http\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LocationsController extends Controller{
    use ResponseTrait, CommonTrait;

    /**
     * Fetch locations info
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function fetch(Request $request): JsonResponse{
        try{
            return $this->apiResponse('0000', __('Success'), [
                'location' => Location::where('id', '=', $request->id)->with('cityRel')->first(),
                'uri' => route('system.admin.trainings.submodules.locations.preview', ['id' => $request->id ])
            ]);
        }catch (\Exception $e){
            return $this->jsonError('5200', __('Desila se greška. Molimo kontaktirajte administratora'));
        }
    }
}
