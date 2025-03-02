@extends('admin.layout.layout')
@section('c-icon')
    <img class="normal-icon" src="{{ asset('files/images/icons/training-instance.svg') }}" alt="{{ __('Training-instance image') }}">
    <img class="yellow-icon" src="{{ asset('files/images/icons/training-instance-yellow.svg') }}" alt="{{ __('Training instance image') }}">
@endsection
@section('c-title') {{ __('Instance obuka') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="#">...</a> /
    <a href="{{ route('system.admin.trainings') }}">{{ __('Instance obuka') }}</a> /
    @isset($create)
        <a href="#">{{ __('Unos') }}</a>
    @else
        <a href="#">{{ $training->title ?? '' }}</a>
    @endisset
@endsection

@section('c-buttons')
    @isset($create)
        <a href="{{ route('system.admin.trainings.instances') }}" title="{{ __('Pregled svih obuka') }}">
            <button class="pm-btn btn pm-btn-info">
                <i class="fas fa-chevron-left"></i>
                <span>{{ __('Nazad') }}</span>
            </button>
        </a>
    @else
        <a href="{{ route('system.admin.trainings.instances.preview', ['id' => $instance->id ]) }}" title="{{ __('Nazad na pregled obuke') }}">
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
                <form action="@if(isset($edit)) {{ route('system.admin.trainings.instances.update') }} @else {{ route('system.admin.trainings.instances.save') }} @endif" method="POST" id="js-form">
                    @if(isset($edit))
                        {{ html()->hidden('id')->class('form-control')->value($instance->id) }}
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ html()->label(__('Program obuka'))->for('training_id')->class('bold') }}
                                {{ html()->select('training_id', $programs, isset($instance) ? $instance->training_id : '')->class('form-control required form-control-sm select2')->required()->disabled(isset($preview)) }}
                                <small id="financed_byHelp" class="form-text text-muted">{{ __('Odaberite program kojem obuka pripada') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('Datum'))->for('application_date')->class('bold') }}
                                {{ html()->text('application_date', '' )->class('form-control required form-control-sm datepicker')->required()->value((isset($instance) ? $instance->startDate() : ''))->isReadonly(isset($preview)) }}
                                <small id="application_dateHelp" class="form-text text-muted">{{ __('Odaberite datum do kad su otvorene prijave') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ html()->label(__('YouTube link'))->for('youtube')->class('bold') }}
                                {{ html()->text('youtube', $instance->youtube ?? '' )->class('form-control form-control-sm')->value((isset($instance) ? $instance->youtube : ''))->isReadonly(isset($preview)) }}
                                <small id="youtubeHelp" class="form-text text-muted">{{ __('Ukolio ima, unesite YouTube link') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{ html()->label(__('Sadržaj obuke'))->for('description')->class('bold') }}
                                {{ html()->textarea('description', '' )->class('form-control form-control-sm')->required()->value((isset($instance) ? $instance->description : ''))->isReadonly(isset($preview))->style('height: 240px;') }}
                                <small id="descriptionHelp" class="form-text text-muted">{{ __('Detaljne informacije o sadržaju obuke') }}</small>
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
