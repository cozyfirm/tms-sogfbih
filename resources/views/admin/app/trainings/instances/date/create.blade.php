@extends('admin.layout.layout')
@section('c-icon')
    <img class="normal-icon" src="{{ asset('files/images/icons/training-instance.svg') }}" alt="{{ __('Training-instance image') }}">
    <img class="yellow-icon" src="{{ asset('files/images/icons/training-instance-yellow.svg') }}" alt="{{ __('Training instance image') }}">
@endsection
@section('c-title') {{ __('Datumi održavanja') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="#">...</a> /
    <a href="{{ route('system.admin.trainings.instances') }}">{{ __('Instance obuka') }}</a> /
    <a href="{{ route('system.admin.trainings.instances.preview', ['id' => $instance->id ]) }}">{{ __('Obuka') }}</a> /

    @isset($create)
        <a href="#">{{ __('Unos') }}</a>
    @else
        <a href="#">{{ $training->title ?? '' }}</a>
    @endisset
@endsection

@section('c-buttons')
    @isset($create)
        <a href="{{ route('system.admin.trainings.instances.preview', ['id' => $instance->id ]) }}" title="{{ __('Nazad na pregled obuke') }}">
            <button class="pm-btn btn pm-btn-info">
                <i class="fas fa-chevron-left"></i>
                <span>{{ __('Nazad') }}</span>
            </button>
        </a>
    @else
        <a href="{{ route('system.admin.trainings.preview', ['id' => $training->id ]) }}" title="{{ __('Nazad na pregled programa obuke') }}">
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
                <form action="@if(isset($edit)) {{ route('system.admin.trainings.instances.date.update') }} @else {{ route('system.admin.trainings.instances.date.save') }} @endif" method="POST" id="js-form">
                    @csrf
                    <!-- Instance ID -->
                    {{ html()->hidden('instance_id')->class('form-control')->value($instance->id) }}

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Lokacija'))->for('location')->class('bold') }}
                                {{ html()->text('location', $date->location ?? '' )->class('form-control form-control-sm')->required()->value((isset($date) ? $date->location : ''))->isReadonly(isset($preview)) }}
                                <small id="locationHelp" class="form-text text-muted">{{ __('Unesite lokaciju gdje se održava obuka') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Datum'))->for('date')->class('bold') }}
                                {{ html()->text('date', $date->date ?? '' )->class('form-control form-control-sm datepicker')->required()->value((isset($date) ? $date->date : ''))->maxlength('10')->isReadonly(isset($preview)) }}
                                <small id="dateHelp" class="form-text text-muted">{{ __('Datum održavanja obuke') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Vrijeme početka'))->for('tf')->class('bold') }}
                                {{ html()->select('tf', $time, isset($date) ? $date->tf : '08:00')->class('form-control form-control-sm select2')->required()->disabled(isset($preview)) }}
                                <small id="tfHelp" class="form-text text-muted">{{ __('Vrijeme početka obuke') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Vrijeme završetka'))->for('td')->class('bold') }}
                                {{ html()->select('td', $time, isset($date) ? $date->td : '08:00')->class('form-control form-control-sm select2')->required()->disabled(isset($preview)) }}
                                <small id="tdHelp" class="form-text text-muted">{{ __('Vrijeme završetka obuke') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12 d-flex justify-content-end gap-5">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="repeat" name="repeat">
                                <label class="form-check-label" for="repeat">Ponovite unos</label>
                            </div>

                            <button type="submit" class="yellow-btn">  {{ __('SAČUVAJTE') }} </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
