<?php

namespace App\Http\Controllers\Admin\Trainings\Submodules;

use App\Http\Controllers\Admin\Core\Filters;
use App\Http\Controllers\Controller;
use App\Models\Core\City;
use App\Models\Core\Keyword;
use App\Models\Trainings\Instances\InstanceTrainer;
use App\Models\User;
use App\Models\Users\Education;
use App\Models\Users\TrainerArea;
use App\Traits\Common\CommonTrait;
use App\Traits\Http\ResponseTrait;
use App\Traits\Trainings\TrainingTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
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
            'cityRel.countryRel.name_ba' => __('Država'),
            'areaRel.name' => __('Oblasti'),
            'educationsRel.levelRel.name' => __('Stepen stručne spreme'),
            'educationsRel.school' => __('Škola / Fakultet'),
            'educationsRel.university' => __('Univerzitet'),
            'educationsRel.title' => __('Stečeno zvanje'),
            'educationsRel.date' => __('Datum diplomiranja')
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

    /* -------------------------------------------------------------------------------------------------------------- */
    /**
     * Education routes
     */
    public function createEducation ($username): View{
        $user = User::where('username', '=', $username)->first();

        return view($this->_path . 'education', [
            'create' => true,
            'user' => $user,
            'educationLevels' => Keyword::getIt('users__education_level'),
        ]);
    }

    public function saveEducation(Request $request): JsonResponse{
        try{
            $request['graduation_date'] = Carbon::parse($request->graduation_date)->format('Y-m-d');

            $user = User::where('id', '=', $request->user_id)->first();

            Education::create([
                'user_id' => $user->id,
                'level' => $request->level,
                'school' => $request->school,
                'university' => $request->university,
                'title' => $request->title,
                'graduation_date' => $request->graduation_date
            ]);

            return $this->jsonSuccess(__('Uspješno ste ažurirali podatke!'), route('system.admin.trainings.submodules.trainers.preview', ['username' => $user->username]));
        }catch (\Exception $e){
            return $this->jsonError('1500', __('Greška prilikom procesiranja podataka. Molimo da nas kontaktirate!'));
        }
    }

    public function editEducation ($id): View{
        $education = Education::where('id', '=', $id)->first();
        $user = User::where('id', '=', $education->user_id)->first();

        return view($this->_path . 'education', [
            'edit' => true,
            'user' => $user,
            'educationLevels' => Keyword::getIt('users__education_level'),
            'education' => $education
        ]);
    }

    public function updateEducation(Request $request): JsonResponse{
        try{
            $request['graduation_date'] = Carbon::parse($request->graduation_date)->format('Y-m-d');

            $user = User::where('id', '=', $request->user_id)->first();

            Education::where('id', '=', $request->id)->update([
                'level' => $request->level,
                'school' => $request->school,
                'university' => $request->university,
                'title' => $request->title,
                'graduation_date' => $request->graduation_date
            ]);

            return $this->jsonSuccess(__('Uspješno ste ažurirali podatke!'), route('system.admin.trainings.submodules.trainers.preview', ['username' => $user->username]));
        }catch (\Exception $e){
            return $this->jsonError('1500', __('Greška prilikom procesiranja podataka. Molimo da nas kontaktirate!'));
        }
    }

    public function deleteEducation ($id): RedirectResponse{
        try{
            $education = Education::where('id', '=', $id)->first();
            $user = User::where('id', '=', $education->user_id)->first();

            $education->delete();

            return redirect()->route('system.admin.trainings.submodules.trainers.preview', ['username' => $user->username]);
        }catch (\Exception $e){
            return back()->with('error', __('Desila se greška. Molimo pokušajte ponovo!'));
        }
    }

    /* -------------------------------------------------------------------------------------------------------------- */
    /**
     * Areas routes
     */
    public function editAreas ($username): View{
        $user = User::where('username', '=', $username)->first();

        return view($this->_path . 'areas', [
            'user' => $user,
            'areas' => Keyword::getIt('trainers__areas')
        ]);
    }

    public function updateAreas(Request $request): JsonResponse{
        try{
            /* First, remove all of them */
            TrainerArea::where('user_id', '=', $request->user_id)->delete();

            /* Get user info */
            $user = User::where('id', '=', $request->user_id)->first();

            foreach ($request->areas as $area){
                TrainerArea::create([
                    'user_id' => $request->user_id,
                    'area_id' => $area
                ]);
            }

            return $this->jsonSuccess(__('Uspješno ste ažurirali podatke!'), route('system.admin.trainings.submodules.trainers.preview', ['username' => $user->username]));
        }catch (\Exception $e){
            return $this->jsonError('1500', __('Greška prilikom procesiranja podataka. Molimo da nas kontaktirate!'));
        }
    }
}
