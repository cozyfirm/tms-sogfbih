@extends('admin.layout.layout')
@section('c-icon')
    <img class="normal-icon" src="{{ asset('files/images/icons/program.svg') }}" alt="{{ __('Training image') }}">
    <img class="yellow-icon" src="{{ asset('files/images/icons/program-yellow.svg') }}"
         alt="{{ __('Training image') }}">
@endsection
@section('c-title')
    {{ $instance->trainingRel->title ?? '' }}
@endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i>
        <p>{{ __('Dashboard') }}</p></a> /
    <a href="#">...</a> /
    <a href="{{ route('system.admin.trainings.instances') }}">{{ __('Instance obuka') }}</a> /
    <a href="#">{{ $instance->trainingRel->title ?? '' }}</a>
@endsection

@section('c-buttons')
    <a href="{{ route('system.admin.trainings.instances') }}" title="{{ __('Pregled svih obuka') }}">
        <button class="pm-btn btn pm-btn-info">
            <i class="fas fa-chevron-left"></i>
            <span>{{ __('Nazad') }}</span>
        </button>
    </a>

    @if(isset($preview))
        <a href="{{ route('system.admin.trainings.instances.edit', ['id' => $instance->id ]) }}">
            <button class="pm-btn pm-btn-white btn pm-btn-edit">
                <i class="fas fa-edit"></i>
            </button>
        </a>
        <a href="{{ route('system.admin.trainings.instances.delete', ['id' => $instance->id ]) }}">
            <button class="pm-btn pm-btn-white btn pm-btn-trash">
                <i class="fas fa-trash"></i>
            </button>
        </a>
    @endif
@endsection

@section('content')
    <!-- Upload files GUI -->
    {{ html()->hidden('image_path')->class('form-control image_path')->value('files/upload/trainings') }}
    {{ html()->hidden('file_path')->class('form-control file_path')->value(storage_path('files/trainings/instances/files')) }}
    {{ html()->hidden('file_type')->class('form-control file_type')->value('instance__file') }}
    {{ html()->hidden('model_id')->class('form-control model_id')->value($instance->id) }}
    {{ html()->hidden('upload_route')->class('form-control upload_route')->value(route('system.admin.trainings.instances.save-files')) }}
    @include('admin.app.shared.files.file-upload')

    <!-- Add trainer -->
    @include('admin.app.trainings.instances.submodules.trainers.add-trainer')
    <!-- Agenda -->
    @include('admin.app.trainings.instances.submodules.events.event')
    <!-- Preview location -->
    @include('admin.app.trainings.instances.submodules.locations.preview')

    <div class="content-wrapper preview-content-wrapper">
        <div class="form__info">
            <div class="form__info__inner">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ html()->label(__('Program obuke'))->for('training_id')->class('bold') }}
                            {{ html()->select('training_id', $programs, isset($instance) ? $instance->training_id : '')->class('form-control form-control-sm select2')->required()->disabled(isset($preview)) }}
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ html()->label(__('Datum'))->for('application_date')->class('bold') }}
                            {{ html()->text('application_date', '' )->class('datepicker form-control form-control-sm')->required()->value(isset($instance) ? $instance->applicationDate() : '')->isReadonly(isset($preview)) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ html()->label(__('Iznos ugovora (KM)'))->for('contract')->class('bold') }}
                            {{ html()->text('contract', $instance->contract ?? '' )->class('form-control form-control-sm')->required()->value((isset($instance) ? $instance->contract : ''))->placeholder('100.00')->isReadonly(isset($preview)) }}
                        </div>
                    </div>
                </div>

                <br>

                @include('admin.app.trainings.instances.submodules.events.events')

                @if($instance->trainersRel->count())
                    <br>

                    <div class="instance__trainers">
                        <h4>{{ __('Treneri na obuci') }}</h4>
                        <div class="trainers">
                            @foreach($instance->trainersRel as $trainer)
                                <div class="trainer__w trainer__w_get_info" rel-id="{{ $trainer->trainer_id }}"
                                     title="{{ __('Više informacija') }}">
                                    <p> {{ $trainer->trainerRel->name ?? '' }} </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="right__menu__info">
            @include('admin.app.trainings.instances.snippets.right-menu')
        </div>
    </div>
@endsection
