<?php

namespace App\Traits\Trainings;

use App\Models\Core\File;
use App\Models\Trainings\Instances\Instance;
use App\Models\Trainings\Instances\InstanceApp;
use App\Models\Trainings\Instances\InstanceEvent;
use App\Models\Trainings\Instances\InstancePresence;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\NoReturn;
use PhpOffice\PhpWord\TemplateProcessor;

trait InstanceTrait{
    protected int $_success = 50;
    /**
     * Check does user satisfied limit for certificate generation
     *
     * @param $application_id
     * @return bool
     */
    protected function checkForPresence($application_id): bool{
        try{
            $application = InstanceApp::where('id', '=', $application_id)->first();
            $totalDays   = $application->instanceRel->totalDays();

            $present = InstancePresence::where('application_id', '=', $application_id)->count();

            return ((($present / $totalDays) * 100) >= $this->_success);
        }catch (\Exception $e){
            return false;
        }
    }

    /**
     * Get start and end of training dates (for certificate)
     *
     * @param $instance
     * @return string
     */
    public function startEndDate($instance): string{
        try{
            $start = InstanceEvent::where('instance_id', '=', $instance->id)->orderBy('date')->first();
            $end   = InstanceEvent::where('instance_id', '=', $instance->id)->orderBy('date', 'DESC')->first();

            $startDate = $start->date;
            $endDate   = $end->date;

            if($startDate != $endDate){
                return "u periodu " . Carbon::parse($startDate)->format('d.m.Y') . " - " . Carbon::parse($endDate)->format('d.m.Y');
            }else return Carbon::parse($startDate)->format('d.m.Y');
        }catch (\Exception $e){
            return Carbon::now()->format('d.m.Y');
        }
    }

    public function instancePlace($instance): string{
        try{
            $start = InstanceEvent::where('instance_id', '=', $instance->id)
                ->where('type', '=', 1)
                ->orderBy('date')->first();

            return $start->locationRel->cityRel->title ?? 'Nije poznato';
        }catch (\Exception $e){
            return __('"Nije poznato"');
        }
    }

    /**
     * Generate docx certificate for training
     *
     * @param $application_id
     * @return bool
     */
    public function generateCertificate($application_id): bool{
        try{
            $templateProcessor = new TemplateProcessor(storage_path('files/trainings/instances/certificates/certificate.docx'));
            $application = InstanceApp::where('id', '=', $application_id)->first();
            $instance    = Instance::where('id', '=', $application->instance_id)->first();

            $templateProcessor->setValue('date', date('d.m.Y'));
            $templateProcessor->setValue('number', date($application_id));
            $templateProcessor->setValue('year', date('Y'));

            $templateProcessor->setValue('name', $application->userRel->name ?? '');
            $templateProcessor->setValue('training', $instance->trainingRel->title ?? '');

            $templateProcessor->setValue('training_date', $this->startEndDate($instance));

            if($application->userRel->gender == 1){
                $templateProcessor->setValue('present', "prisustvovao");
            }else{
                $templateProcessor->setValue('present', "prisustvovala");
            }

            $templateProcessor->setValue('place', $this->instancePlace($instance));

            /** @var $userName; Extract for username */
            $userName = str_replace('-', '_', strtolower($application->userRel->username ?? ''));

            $fileName = $userName . date('_d_m_y'). '.docx';
            $templateProcessor->saveAs(storage_path('files/trainings/instances/certificates/user-certificates/' . $fileName));

            /** Create file and certificate name */
            $file = File::create([
                'file' => ($application->userRel->name ?? '') . ' - ' . ($instance->trainingRel->title ?? '') . '.docx',
                'name' => $fileName,
                'ext' => 'docx',
                'type' => 'certificate',
                'path' => 'files/trainings/instances/certificates/user-certificates/',
                'created_by' => Auth::user()->id
            ]);

            $application->update([ 'certificate_id' => $file->id ]);

            return true;
        }catch (\Exception $e){
            return false;
        }
    }

    /**
     * Update instance statistics, such as:
     *
     *  1. total_applications
     *  2. total_males
     *  3. total_females
     * @param $instance_id
     * @return void
     */
    public function updateStatistics($instance_id): void{
        try{
            $applications = InstanceApp::where('instance_id', '=', $instance_id)->get();
            $males = 0; $females = 0;

            foreach ($applications as $application){
                if(isset($application->userRel)){
                    if($application->userRel->gender == 1) $males += 1;
                    else $females += 1;
                }
            }

            /** Update instance */
            Instance::where('id', '=', $instance_id)->update([
                'total_applications' => $applications->count(),
                'total_males' => $males,
                'total_females' => $females
            ]);
        }catch (\Exception $e){}
    }

    /**
     * Update instance duration, including:
     *  1. Start date
     *  2. End date
     *  3. Total duration
     *
     * @param $instance_id
     * @return void
     */
    public function updateDuration($instance_id): void{
        try{
            $start = InstanceEvent::where('instance_id', '=', $instance_id)->orderBy('date')->first();
            $end   = InstanceEvent::where('instance_id', '=', $instance_id)->orderBy('date', 'DESC')->first();

            /** Update instance */
            Instance::where('id', '=', $instance_id)->update([
                'start_date' => $start->date,
                'end_date' => $end->date,
                'duration' => InstanceEvent::where('instance_id', '=', $instance_id)->get()->unique('date')->count()
            ]);
        }catch (\Exception $e){}
    }
}
