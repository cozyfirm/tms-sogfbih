@extends('admin.layout.layout')
@section('c-icon') <i class="fa-solid fa-calendar-days"></i> @endsection
@section('c-title') {{ __('Interni događaji') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="{{ route('system.admin.other.internal-events') }}">{{ __('Interni događaji') }}</a> /
    @isset($create)
        <a href="#">{{ __('Unos') }}</a>
    @else
        <a href="#">{{ $event->projectRel->name ?? '' }}</a>
    @endisset
@endsection

@section('c-buttons')
    <a href="@if(isset($create) or isset($preview)) {{ route('system.admin.other.internal-events') }} @else {{ route('system.admin.other.internal-events.preview', ['id' => $event->id ]) }} @endif" title="{{ __('Nazad') }}">
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
                <form action="@if(isset($edit)) {{ route('system.admin.other.internal-events.update') }} @else {{ route('system.admin.other.internal-events.save') }} @endif" method="POST" id="js-form">
                    @if(isset($edit))
                        {{ html()->hidden('id')->class('form-control')->value($event->id) }}
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ html()->label(__('Projekat'))->for('project')->class('bold') }}
                                {{ html()->select('project', $projects, isset($event) ? $event->project : '')->class('form-control form-control-sm single-select2')->required()->disabled(isset($preview)) }}
                                <small id="projectHelp" class="form-text text-muted">{{ __('Odaberite projekat') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Lokacija'))->for('location_id')->class('bold') }}
                                {{ html()->select('location_id', $locations, isset($event) ? $event->location_id : '')->class('form-control form-control-sm single-select2')->required()->disabled(isset($preview)) }}
                                <small id="location_idHelp" class="form-text text-muted">{{ __('Odaberite lokaciju gdje se održava') }}</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {{ html()->label(__('Datum'))->for('date')->class('bold') }}
                                {{ html()->text('date')->class('form-control form-control-sm datepicker')->required()->value((isset($event) ? $event->date() : date('d.m.Y')))->isReadonly(isset($preview)) }}
                                <small id="dateHelp" class="form-text text-muted">{{ __('Datum održavanja') }}</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {{ html()->label(__('Vrijeme'))->for('time')->class('bold') }}
                                {{ html()->select('time', $time, '08:00')->class('form-control form-control-sm single-select2')->style('width:100%;')->required()->value((isset($event) ? $event->time : '08:00'))->isReadonly(isset($preview)) }}
                                <small id="timeHelp" class="form-text text-muted">{{ __('Vrijeme održavanja') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ html()->label(__('YouTube link'))->for('youtube')->class('bold') }}
                                {{ html()->text('youtube')->class('form-control form-control-sm')->value((isset($event) ? $event->youtube : ''))->isReadonly(isset($preview))->maxlength(200) }}
                                <small id="youtubeHelp" class="form-text text-muted">{{ __('YouTube link ukoliko postoji') }}</small>
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
