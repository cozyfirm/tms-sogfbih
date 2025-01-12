<?php

namespace App\Traits\Trainings;
use App\Models\Core\Keyword;
use App\Models\Trainigs\TrainingArea;
use Illuminate\Http\Request;

trait TrainingTrait{
    public function handleAreas($select2, $trainingID): void{
        foreach ($select2 as &$data){
            if($data['type'] == 'unknown'){
                $sample = Keyword::where('name', '=', $data['value'])->where('type', '=', 'trainings__areas')->first();
                if(!$sample){
                    $sample = Keyword::create([
                        'name' => $data['value'],
                        'type' => 'trainings__areas'
                    ]);
                }
                $data['value'] = $sample->id;
                $data['type'] = 'valid';
            }
        }

        /**
         *  Remove all areas
         */
        TrainingArea::where('training_id', '=', $trainingID)->delete();

        foreach ($select2 as &$data){
            if($data['type'] == 'valid'){
                TrainingArea::create([
                    'training_id' => $trainingID,
                    'area_id' => $data['value']
                ]);
            }
        }
    }
}
