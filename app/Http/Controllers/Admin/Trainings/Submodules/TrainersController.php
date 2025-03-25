<?php

namespace App\Http\Controllers\Admin\Trainings\Submodules;

use App\Http\Controllers\Admin\Core\Filters;
use App\Http\Controllers\Controller;
use App\Models\Core\City;
use App\Models\Core\Keyword;
use App\Models\Trainings\Instances\InstanceTrainer;
use App\Models\User;
use App\Traits\Common\CommonTrait;
use App\Traits\Http\ResponseTrait;
use App\Traits\Trainings\TrainingTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrainersController extends Controller{
    use ResponseTrait, CommonTrait, TrainingTrait;

    protected string $_path = 'admin.app.trainings.submodules.trainers.';

    public function index(): View{
        $users = User::where('role', '=', 'trainer');
        $users = Filters::filter($users);

        $filters = [
            'name' => __('Ime i prezime'),
            'email' => 'Email',
            'role' => __('Uloga'),
            'phone' => __('Telefon'),
            'birth_date' => __('Datum rođenja'),
            'trainersRel.instanceRel.trainingRel.title' => __('Program obuke'),
            'trainersRel.grade' => __('Ocjena'),
            'trainersRel.contract' => __('Vrijednost ugovora'),
            'address' => __('Adresa'),
            'cityRel.title' => __('Grad'),
            'cityRel.countryRel.name_ba' => __('Država')
        ];

        return view($this->_path . 'index', [
            'filters' => $filters,
            'users' => $users
        ]);
    }

    public function preview ($username): View{
        $user = User::where('username', '=', $username)->first();
        $trainings = InstanceTrainer::where('trainer_id', '=', $user->id)
            ->join('trainings__instances', 'trainings__instances.id', '=', 'trainings__instances_trainers.instance_id')
            ->orderBy('trainings__instances.application_date', 'DESC')
            ->select('trainings__instances_trainers.*') //see PS
            ->get();

        return view($this->_path . 'preview', [
            'preview' => true,
            'user' => $user,
            'gender' => Keyword::getIt('gender'),
            'trainings' => $trainings
        ]);
    }

    /**
     * Fetch data for trainer from instance -> trainer relationship
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function fetch(Request $request): JsonResponse{
        try{
            $instanceTrainer = InstanceTrainer::where('id', '=', $request->id)->with('instanceRel.trainingRel')->first();
            $instanceTrainer->dateFrom = isset($instanceTrainer->instanceRel) ? $instanceTrainer->instanceRel->startDate() : date('d.m.Y');
            $instanceTrainer->dateTo   = isset($instanceTrainer->instanceRel) ? $instanceTrainer->instanceRel->endDate() : date('d.m.Y');

            return $this->apiResponse('0000', __('Success'), [
                'info' => $instanceTrainer
            ]);
        }catch (\Exception $e){
            return $this->jsonError('5100', __('Desila se greška. Molimo kontaktirajte administratora'));
        }
    }
}
