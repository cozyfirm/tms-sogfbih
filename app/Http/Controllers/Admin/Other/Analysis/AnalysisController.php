<?php

namespace App\Http\Controllers\Admin\Other\Analysis;

use App\Http\Controllers\Admin\Core\Filters;
use App\Http\Controllers\Controller;
use App\Models\Other\Analysis\Analysis;
use App\Traits\Common\CommonTrait;
use App\Traits\Http\ResponseTrait;
use App\Traits\Trainings\TrainingTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnalysisController extends Controller{
    use ResponseTrait, CommonTrait, TrainingTrait;
    protected string $_path = 'admin.app.other.analysis.';


    public function index(): View{
        $analyses = Analysis::orderBy('id', 'DESC');
        $analyses = Filters::filter($analyses);

        $filters = [
            'title' => 'Naslov',
            'date_from' => __('Datum od'),
            'date_to' => __('Datum do'),
            'views' => __('Posjeta'),
            'submissions' => __('Popunjenih anketa')
        ];

        return view($this->_path . 'index', [
            'filters' => $filters,
            'analyses' => $analyses
        ]);
    }

    public function create(): View{
        return view($this->_path . 'create', [
            'create' => true
        ]);
    }

    public function save(Request $request): JsonResponse{
        try{
            $request['date_from'] = Carbon::parse($request->date_from)->format('Y-m-d');
            $request['date_to'] = Carbon::parse($request->date_to)->format('Y-m-d');
            $request['hash'] = md5($request->date_from  . time());

            // Create instance
            $analysis = Analysis::create($request->except(['_token']));

            return $this->jsonSuccess(__('Uspješno unesena obuka!'), route('system.admin.other.analysis.preview', ['id' => $analysis->id ]));
        }catch (\Exception $e){
            return $this->jsonError('2000', __('Greška prilikom obrade podataka. Molmo kontaktirajte administratora!'));
        }
    }

    public function preview($id): View{
        return view($this->_path . 'preview', [
            'preview' => true,
            'analysis' => Analysis::where('id', '=', $id)->first()
        ]);
    }

    public function edit($id): View{
        return view($this->_path . 'create', [
            'edit' => true,
            'analysis' => Analysis::where('id', '=', $id)->first()
        ]);
    }

    public function update(Request $request): JsonResponse{
        try{
            $request['date_from'] = Carbon::parse($request->date_from)->format('Y-m-d');
            $request['date_to'] = Carbon::parse($request->date_to)->format('Y-m-d');

            // Create instance
            Analysis::where('id', '=', $request->id)->update($request->except(['_token']));

            return $this->jsonSuccess(__('Uspješno unesena obuka!'), route('system.admin.other.analysis.preview', ['id' => $request->id ]));
        }catch (\Exception $e){
            return $this->jsonError('2000', __('Greška prilikom obrade podataka. Molmo kontaktirajte administratora!'));
        }
    }

    public function delete($id): RedirectResponse{
        try{
            Analysis::where('id', '=', $id)->delete();
            return redirect()->route('system.admin.other.analysis')->with('success', __('Uspješno obrisano!'));
        }catch (\Exception $e){ return back()->with('error', __('Došlo je do greške. Molimo kontaktirajte administratora!')); }
    }
}
