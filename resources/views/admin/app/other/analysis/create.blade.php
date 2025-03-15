@extends('admin.layout.layout')
@section('c-icon') <i class="fa-solid fa-magnifying-glass-chart"></i> @endsection
@section('c-title') {{ __('Analize potreba za obukama') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="{{ route('system.admin.other.analysis') }}">{{ __('Analiza potreba za obukama') }}</a> /
    @isset($create)
        <a href="#">{{ __('Unos') }}</a>
    @else
        <a href="#">{{ $analysis->title ?? '' }}</a>
    @endisset
@endsection

@section('c-buttons')
    <a href="@if(isset($create) or isset($preview)) {{ route('system.admin.other.analysis') }} @else {{ route('system.admin.other.analysis.preview', ['id' => $analysis->id ]) }} @endif" title="{{ __('Nazad') }}">
        <button class="pm-btn btn pm-btn-info">
            <i class="fas fa-chevron-left"></i>
            <span>{{ __('Nazad') }}</span>
        </button>
    </a>
@endsection

@section('content')
    <div class="content-wrapper content-wrapper-p-15">
        <div class="row">
            <div class="col-md-12">
                <form action="@if(isset($edit)) {{ route('system.admin.other.analysis.update') }} @else {{ route('system.admin.other.analysis.save') }} @endif" method="POST" id="js-form">
                    @if(isset($edit))
                        {{ html()->hidden('id')->class('form-control')->value($analysis->id) }}
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ html()->label(__('Naslov'))->for('title')->class('bold') }}
                                {{ html()->text('title')->class('form-control form-control-sm')->value((isset($analysis) ? $analysis->title : ''))->isReadonly(isset($preview))->maxlength(200) }}
                                <small id="titleHelp" class="form-text text-muted">{{ __('Unesite naslov') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Datum početka'))->for('date_from')->class('bold') }}
                                {{ html()->text('date_from')->class('form-control form-control-sm datepicker')->required()->value((isset($analysis) ? $analysis->dateFrom() : date('d.m.Y')))->isReadonly(isset($preview)) }}
                                <small id="date_fromHelp" class="form-text text-muted">{{ __('Datum početka analize') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Datum završetka'))->for('date_to')->class('bold') }}
                                {{ html()->text('date_to')->class('form-control form-control-sm datepicker')->required()->value((isset($analysis) ? $analysis->dateTo() : date('d.m.Y')))->isReadonly(isset($preview)) }}
                                <small id="date_toHelp" class="form-text text-muted">{{ __('Datum završetka analize') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ html()->label(__('Opis'))->for('description')->class('bold') }}
                                {{ html()->textarea('description')->class('form-control form-control-sm')->value((isset($analysis) ? $analysis->description : ''))->style('height: 240px !important;')->isReadonly(isset($preview)) }}
                                <small id="descriptionHelp" class="form-text text-muted">{{ __('Detaljan opis analize') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12 d-flex justify-content-end">
                            <button type="submit" class="yellow-btn">  {{ __('SAČUVAJTE') }} </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
