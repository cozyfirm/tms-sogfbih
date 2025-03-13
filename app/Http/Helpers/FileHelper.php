<?php

use App\Models\Core\File;
use App\Models\Trainings\Instances\Instance;
use App\Models\Trainings\TrainingArea;

class FileHelper{
    protected static array $_imageExt = ['jpeg', 'jpg', 'png', 'svg'];
    protected static array $_fileExt = ['doc', 'docx', 'xls', 'xlsx', 'pdf'];

    /**
     * Get instance images
     * @param $model_id
     * @return mixed
     */
    public static function getInstanceImages($model_id): mixed{
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

    /**
     * Get instance files (ALl files)
     * @param $model_id
     * @return mixed
     */
    public static function getInstanceFiles($model_id): mixed{
        return File::whereHas('instanceRel.instanceRel', function ($q) use ($model_id){
            $q->where('id', '=', $model_id);
        })->whereIn('ext', self::$_fileExt)->with('instanceRel')->get();
    }

    /**
     * Get instance public files (for other users, not just admins)
     * @param $model_id
     * @return mixed
     */
    public static function getPublicInstanceFiles($model_id): mixed{
        return File::whereHas('instanceRel', function ($q){
            $q->where('visibility', '=', 'public');
        })->whereHas('instanceRel.instanceRel', function ($q) use ($model_id){
            $q->where('id', '=', $model_id);
        })->whereIn('ext', self::$_fileExt)->with('instanceRel')->get();
    }

    /**
     * Get Internal events files
     * @param $model_id
     * @return mixed
     */
    public static function getIEFiles($model_id): mixed{
        return File::whereHas('ieREl.ieREl', function ($q) use ($model_id){
            $q->where('id', '=', $model_id);
        })->whereIn('ext', self::$_fileExt)->with('ieREl')->get();
    }

    /**
     * Get Internal events images (for gallery)
     * @param $model_id
     * @return mixed
     */
    public static function getIEImages($model_id): mixed{
        return File::whereHas('instanceRel.instanceRel', function ($q) use ($model_id){
            $q->where('id', '=', $model_id);
        })->whereIn('ext', self::$_imageExt)->with('instanceRel')->get();
    }
}
