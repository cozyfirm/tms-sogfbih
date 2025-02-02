<?php

namespace App\Http\Controllers\Admin\Core;

use App\Http\Controllers\Controller;
use App\Traits\Common\FileTrait;
use App\Traits\Http\ResponseTrait;
use Illuminate\Http\Request;

class FileUploadController extends Controller{
    use ResponseTrait, FileTrait;
    protected string $_path = 'files/';

    public function upload(Request $request){
        try{
            // $request['path'] = (storage_path('files/trainings'));
            $file = $this->saveFile($request, 'file', $request->type);

            /* ToDo:: Add extensions check and remove elements .. */

            return $this->apiResponse('0000', __('Success'), [
                'file' => $file
            ]);
        }catch (\Exception $e){}
    }
}
