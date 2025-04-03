<?php

namespace App\Traits\Trainings;

use App\Models\Core\File;
use App\Models\Trainings\Instances\Instance;
use App\Models\Trainings\Instances\InstanceApp;
use App\Models\Trainings\Instances\InstancePresence;
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
            $templateProcessor->setValue('training_date', $instance->startDate() ?? '');
            $templateProcessor->setValue('place', "Mjesto održavanja obuke");

            if($application->userRel->gender == 1){
                $templateProcessor->setValue('present', "prisustvovao");
            }else{
                $templateProcessor->setValue('present', "prisustvovala");
            }

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
                'path' => 'files/trainings/instances/certificates/user-certificates/'
            ]);

            $application->update([
                'presence' => 1,
                'certificate_id' => $file->id
            ]);

            return true;
        }catch (\Exception $e){
            return false;
        }
    }
}
