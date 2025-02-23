<?php

namespace App\Traits\Trainings;
use App\Models\Core\Keyword;
use App\Models\Trainings\TrainingArea;
use Illuminate\Http\Request;

trait TrainingTrait{
    /**
     * Handle select2 items (multiple select2); Check if exists in keyword, if not, insert it
     *
     * @param $select2
     * @param $trainingID
     * @param $type
     * @return void
     */
    public function handleSelect2Items($select2, $trainingID, $type, $model, $column): void{
        foreach ($select2 as &$data){
            if($data['type'] == 'unknown'){
                $sample = Keyword::where('name', '=', $data['value'])->where('type', '=', $type)->first();
                if(!$sample){
                    $sample = Keyword::create([
                        'name' => $data['value'],
                        'type' => $type
                    ]);
                }
                $data['value'] = $sample->id;
                $data['type'] = 'valid';
            }
        }

        /**
         *  Remove all areas
         */
        $model::where('training_id', '=', $trainingID)->delete();

        foreach ($select2 as &$data){
            if($data['type'] == 'valid'){
                $model::create([
                    'training_id' => $trainingID,
                    $column => $data['value']
                ]);
            }
        }
    }
}
