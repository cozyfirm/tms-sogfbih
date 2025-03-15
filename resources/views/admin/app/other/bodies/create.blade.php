@extends('admin.layout.layout')
@section('c-icon') <i class="fas fa-info-circle"></i> @endsection
@section('c-title') {{ __('Organi i tijela') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="{{ route('system.admin.other.bodies') }}">{{ __('Interni događaji') }}</a> /
    @isset($create)
        <a href="#">{{ __('Unos') }}</a>
    @else
        <a href="#">{{ $body->title ?? '' }}</a>
    @endisset
@endsection

@section('c-buttons')
    <a href="@if(isset($create) or isset($preview)) {{ route('system.admin.other.bodies') }} @else {{ route('system.admin.other.bodies.preview', ['id' => $body->id ]) }} @endif" title="{{ __('Nazad') }}">
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
                <form action="@if(isset($edit)) {{ route('system.admin.other.bodies.update') }} @else {{ route('system.admin.other.bodies.save') }} @endif" method="POST" id="js-form">
                    @if(isset($edit))
                        {{ html()->hidden('id')->class('form-control')->value($body->id) }}
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ html()->label(__('Naslov'))->for('title')->class('bold') }}
                                {{ html()->text('title')->class('form-control form-control-sm')->value((isset($body) ? $body->title : ''))->isReadonly(isset($preview))->maxlength(200) }}
                                <small id="titleHelp" class="form-text text-muted">{{ __('Unesite naslov') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Lokacija'))->for('location_id')->class('bold') }}
                                {{ html()->select('location_id', $locations, isset($body) ? $body->location_id : '')->class('form-control form-control-sm single-select2')->required()->disabled(isset($preview)) }}
                                <small id="location_idHelp" class="form-text text-muted">{{ __('Odaberite lokaciju gdje se održava') }}</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {{ html()->label(__('Datum'))->for('date')->class('bold') }}
                                {{ html()->text('date')->class('form-control form-control-sm datepicker')->required()->value((isset($body) ? $body->date() : date('d.m.Y')))->isReadonly(isset($preview)) }}
                                <small id="dateHelp" class="form-text text-muted">{{ __('Datum održavanja') }}</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {{ html()->label(__('Vrijeme'))->for('time')->class('bold') }}
                                {{ html()->select('time', $time, '08:00')->class('form-control form-control-sm single-select2')->style('width:100%;')->required()->value((isset($body) ? $body->time : '08:00'))->isReadonly(isset($preview)) }}
                                <small id="timeHelp" class="form-text text-muted">{{ __('Vrijeme održavanja') }}</small>
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
