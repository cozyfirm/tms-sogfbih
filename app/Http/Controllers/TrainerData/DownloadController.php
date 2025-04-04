<?php

namespace App\Http\Controllers\TrainerData;

use App\Http\Controllers\Controller;
use App\Models\Core\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DownloadController extends Controller{
    /**
     * Download public files from instance
     *
     * @param $id
     * @return RedirectResponse|BinaryFileResponse
     */
    public function downloadInstanceFile($id): RedirectResponse | BinaryFileResponse{
        try{
            $file = File::where('id', '=', $id)->first();
            if(!isset($file->instanceRel->instanceRel)) return back()->with('error', __('Desila se greška prilikom preuzimanja dokumenta!'));

            if(Auth::user()->isAdmin()){
                return response()->download(storage_path('files/trainings/instances/files/' . $file->name), $file->file);
            }else{
                if($file->instanceRel->visibility == 'public'){
                    return response()->download(storage_path('files/trainings/instances/files/' . $file->name), $file->file);
                }else{
                    return back()->with('error', __('Pristup dokumentu nije dozvoljen!'));
                }
            }
        }catch (\Exception $e){ return back()->with('error', __('Desila se greška prilikom preuzimanja dokumenta!')); }
    }
}
