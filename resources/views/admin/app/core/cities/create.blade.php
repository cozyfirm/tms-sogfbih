@extends('admin.layout.layout')
@section('c-icon') <i class="fas fa-building"></i> @endsection
@section('c-title') {{ __('Općine i gradovi') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="{{ route('system.admin.core.settings.cities') }}">{{ __('Pregled svih općina i gradova') }}</a> /
    @isset($create)
        <a href="#">{{ __('Unos') }}</a>
    @else
        <a href="#">{{ $city->title ?? '' }}</a>
    @endisset
@endsection

@section('c-buttons')
    <a href="{{ route('system.admin.core.settings.cities') }}">
        <button class="pm-btn btn pm-btn-info">
            <i class="fas fa-chevron-left"></i>
            <span>{{ __('Nazad') }}</span>
        </button>
    </a>

    @if(isset($preview))
        <a href="#">
            <button class="pm-btn btn pm-btn-edit">
                <i class="fas fa-edit"></i>
            </button>
        </a>
    @endif
@endsection

@section('content')
    <div class="content-wrapper content-wrapper-p-15">
        <div class="row">
            <div class="col-md-12">
                <form action="@if(isset($edit)) {{ route('system.admin.core.settings.cities.update') }} @else {{ route('system.admin.core.settings.cities.save') }} @endif" method="POST" id="js-form">
                    @if(isset($edit))
                        {{ html()->hidden('id')->class('form-control')->value($city->id) }}
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ html()->label(__('Naziv'))->for('title')->class('bold') }}
                                {{ html()->text('title', $city->title ?? '' )->class('form-control form-control-sm')->required()->value((isset($city) ? $city->title : ''))->isReadonly(isset($preview)) }}
                                <small id="titleHelp" class="form-text text-muted">{{ __('Puni naziv općine ili grada') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Država'))->for('country_id')->class('bold') }}
                                {{ html()->select('country_id', $countries, isset($city) ? $city->country_id : '21')->class('form-control form-control-sm')->required()->disabled(isset($preview)) }}
                                <small id="country_idHelp" class="form-text text-muted">{{ __('Puni naziv općine ili grada') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Vrsta'))->for('type')->class('bold') }}
                                {{ html()->select('type', $types, isset($city) ? $city->type : '')->class('form-control form-control-sm')->required()->disabled(isset($preview)) }}
                                <small id="typeHelp" class="form-text text-muted">{{ __('Općina ili grad') }}</small>
                            </div>
                        </div>
                    </div>

                    @if(!isset($preview))
                        <div class="row mt-4">
                            <div class="col-md-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-dark btn-sm"> {{ __('SAČUVAJTE') }} </button>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection
