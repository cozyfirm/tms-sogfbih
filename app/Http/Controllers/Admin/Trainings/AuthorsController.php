<?php

namespace App\Http\Controllers\Admin\Trainings;

use App\Http\Controllers\Admin\Core\Filters;
use App\Http\Controllers\Controller;
use App\Models\Core\City;
use App\Models\Core\Keyword;
use App\Models\Trainigs\Author;
use App\Traits\Common\CommonTrait;
use App\Traits\Http\ResponseTrait;
use App\Traits\Trainings\TrainingTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthorsController extends Controller{
    use ResponseTrait, CommonTrait, TrainingTrait;
    protected string $_path = 'admin.app.trainings.authors.';

    public function index(): View{
        $authors = Author::orderBy('title', 'DESC');
        $authors = Filters::filter($authors);

        $filters = [
            'title' => 'Naziv',
            'typeRel.name' => __('Fizičko ili pravno lice'),
            'email' => __('Email adresa'),
            'address' => __('Adresa'),
            'cityRel.name' => __('Grad'),
            'phone' => __('Broj telefona'),
            'cellphone' => __('Broj mobitela')
        ];

        return view($this->_path . 'index', [
            'filters' => $filters,
            'authors' => $authors
        ]);
    }
    public function preview($id): View{
        return view($this->_path . 'create', [
            'preview' => true,
            'cities' => City::pluck('title', 'id'),
            'userTypes' => Keyword::getIt('user_type'),
            'author' => Author::where('id', '=', $id)->first()
        ]);
    }
    public function edit($id): View{
        return view($this->_path . 'create', [
            'edit' => true,
            'cities' => City::pluck('title', 'id'),
            'userTypes' => Keyword::getIt('user_type'),
            'author' => Author::where('id', '=', $id)->first()
        ]);
    }
    public function update(Request $request){
        try{
            Author::where('id', '=', $request->id)->update($request->except(['_token', 'id']));

            return $this->jsonSuccess(__('Uspješno ažurirano!'), route('system.admin.trainings.authors.preview', ['id' => $request->id ]));
        }catch (\Exception $e){
            return $this->jsonError('2020', __('Greška prilikom obrade podataka. Molmo kontaktirajte administratora!'));
        }
    }
    public function delete($id): RedirectResponse{
        try{
            Author::where('id', '=', $id)->delete();
            return redirect()->route('system.admin.trainings.authors');
        }catch (\Exception $e){ return back()->with('error', __('Greška prilikom brisanja. Molimo kontaktirajte administratora')); }
    }
}
