<?php

use App\Models\Core\File;
use App\Models\Trainings\Instances\Instance;
use App\Models\Trainings\TrainingArea;

class FileHelper{
    protected static array $_imageExt = ['jpeg', 'jpg', 'png', 'svg'];
    protected static array $_fileExt = ['doc', 'docx', 'xls', 'xlsx', 'pdf'];

    public static function getInstanceImages($model_id){
        if(Auth()->user()->isAdmin()){
            return File::whereHas('instanceRel.instanceRel', function ($q) use ($model_id){
                $q->where('id', '=', $model_id);
            })->whereIn('ext', self::$_imageExt)->with('instanceRel')->get();
        }else{
            return File::whereHas('instanceRel.instanceRel', function ($q) use ($model_id){
                $q->where('id', '=', $model_id)->where('visibility', '=', 'public');
            })->whereIn('ext', self::$_imageExt)->with('instanceRel')->get();
        }
    }

    public static function getInstanceFiles($model_id){
        return File::whereHas('instanceRel.instanceRel', function ($q) use ($model_id){
            $q->where('id', '=', $model_id);
        })->whereIn('ext', self::$_fileExt)->with('instanceRel')->get();
    }

    public static function getPublicInstanceFiles($model_id){
        return File::whereHas('instanceRel', function ($q){
            $q->where('visibility', '=', 'public');
        })->whereHas('instanceRel.instanceRel', function ($q) use ($model_id){
            $q->where('id', '=', $model_id);
        })->whereIn('ext', self::$_fileExt)->with('instanceRel')->get();
    }
}
