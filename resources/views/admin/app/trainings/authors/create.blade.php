@extends('admin.layout.layout')
@section('c-icon')
    <i class="fas fa-users"></i>
@endsection
@section('c-title') {{ __('Programi obuka') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="#">..</a> /
    <a href="{{ route('system.admin.trainings.authors') }}">{{ __('Autori programa obuka') }}</a> /
    <a href="{{ route('system.admin.trainings.authors.preview', ['id' => $author->id]) }}">{{ $author->title ?? '' }}</a>
@endsection

@section('c-buttons')
    @isset($preview)
        <a href="{{ route('system.admin.trainings.authors') }}" title="{{ __('Pregled svih autora programa obuka') }}">
            <button class="pm-btn btn pm-btn-info">
                <i class="fas fa-chevron-left"></i>
                <span>{{ __('Nazad') }}</span>
            </button>
        </a>
        <a href="{{ route('system.admin.trainings.authors.edit', ['id' => $author->id ]) }}" title="{{ __('Uredite autora') }}">
            <button class="pm-btn pm-btn-white btn pm-btn-edit">
                <i class="fas fa-edit"></i>
            </button>
        </a>
        <a href="{{ route('system.admin.trainings.authors.delete', ['id' => $author->id ]) }}">
            <button class="pm-btn pm-btn-white btn pm-btn-trash">
                <i class="fas fa-trash"></i>
            </button>
        </a>
    @else
        <a href="{{ route('system.admin.trainings.authors.preview', ['id' => $author->id ]) }}" title="{{ __('Nazad na pregled autora') }}">
            <button class="pm-btn btn pm-btn-info">
                <i class="fas fa-chevron-left"></i>
                <span>{{ __('Nazad') }}</span>
            </button>
        </a>
    @endisset
@endsection

@section('content')
    <div class="content-wrapper content-wrapper-p-15">
        <div class="row">
            <div class="col-md-12">
                <form action="@if(isset($edit)) {{ route('system.admin.trainings.authors.update') }} @endif" method="POST" id="js-form">
                    @if(isset($edit))
                        {{ html()->hidden('id')->class('form-control')->value($author->id) }}
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ html()->label(__('Fizičko ili pravno lice'))->for('type')->class('bold') }}
                                {{ html()->select('type', $userTypes, $author->type ?? '18')->class('form-control form-control-sm author_type')->required()->disabled(isset($preview)) }}
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Ime i prezime'))->for('title')->class('bold author_title_label') }}
                                {{ html()->text('title', $author->title ?? '' )->class('form-control form-control-sm')->required()->value((isset($author) ? $author->title : ''))->isReadonly(isset($preview))->maxlength(200) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Email'))->for('email')->class('bold') }}
                                {{ html()->email('email', $author->email ?? '' )->class('form-control form-control-sm')->required()->value((isset($author) ? $author->email : ''))->isReadonly(isset($preview))->maxlength(200) }}
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Adresa'))->for('address')->class('bold') }}
                                {{ html()->text('address', $author->address ?? '' )->class('form-control form-control-sm')->required()->value((isset($author) ? $author->address : ''))->isReadonly(isset($preview))->maxlength(200) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Grad'))->for('city')->class('bold') }}
                                {{ html()->select('city', $cities, isset($author) ? $author->city : '')->class('form-control form-control-sm single-select2')->style('width:100%;')->required()->disabled(isset($preview)) }}
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Broj telefona'))->for('phone')->class('bold') }}
                                {{ html()->text('phone', $author->phone ?? '' )->class('form-control form-control-sm')->required()->value((isset($author) ? $author->phone : ''))->isReadonly(isset($preview))->maxlength(20) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Broj mobitela'))->for('cellphone')->class('bold') }}
                                {{ html()->text('cellphone', $author->cellphone ?? '' )->class('form-control form-control-sm')->required()->value((isset($author) ? $author->cellphone : ''))->isReadonly(isset($preview))->maxlength(20) }}
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ html()->label(__('Napomena'))->for('comment')->class('bold') }}
                                {{ html()->textarea('comment', $author->comment ?? '' )->class('form-control form-control-sm')->required()->maxlength(500)->isReadonly(isset($preview))->style('height:80px;') }}
                            </div>
                        </div>
                    </div>

                    @if(!isset($preview))
                        <div class="row mt-4">
                            <div class="col-md-12 d-flex justify-content-end">
                                <button type="submit" class="yellow-btn">  {{ __('SAČUVAJTE') }} </button>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection
