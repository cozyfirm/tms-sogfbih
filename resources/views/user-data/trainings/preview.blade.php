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
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="{{ route('system.user-data.trainings') }}">{{ __('Sistem obuka') }}</a> /
    <a href="{{ route('system.user-data.trainings.preview', ['id' => $instance->id ]) }}">{{ $instance->trainingRel->title ?? '' }}</a>
@endsection

@section('c-buttons')
    <a href="{{ route('system.user-data.trainings') }}" title="{{ __('Pregled svih obuka') }}">
        <button class="pm-btn btn pm-btn-info">
            <i class="fas fa-chevron-left"></i>
            <span>{{ __('Nazad') }}</span>
        </button>
    </a>
@endsection

@section('content')
    <!-- Preview location -->
    @include('admin.app.trainings.instances.submodules.locations.preview')

    <div class="content-wrapper preview-content-wrapper">
        <div class="form__info">
            <div class="form__info__inner">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ html()->label(__('Naziv obuke'))->for('training_id')->class('bold') }}
                            {{ html()->text('training_id')->class('form-control form-control-sm')->required()->value((isset($instance->trainingRel) ? $instance->trainingRel->title : ''))->isReadonly(isset($preview)) }}
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ html()->label(__('Datum'))->for('application_date')->class('bold') }}
                            {{ html()->text('application_date')->class('form-control form-control-sm')->required()->value(isset($instance) ? $instance->applicationDate() : '')->isReadonly(isset($preview)) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ html()->label(__('Broj prijavljenih kandidata'))->for('total_applications')->class('bold') }}
                            {{ html()->text('total_applications')->class('form-control form-control-sm')->required()->value((isset($instance) ? $instance->total_applications : ''))->isReadonly(isset($preview)) }}
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
                                <div class="trainer__w">
                                    <p> {{ $trainer->trainerRel->name ?? '' }} </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="right__menu__info">
            @include('user-data.trainings.includes.right-menu')
        </div>
    </div>
@endsection
