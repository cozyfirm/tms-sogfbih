@extends('admin.layout.layout')
@section('c-icon') <i class="fa-solid fa-calendar-days"></i> @endsection
@section('c-title') {{ __('Interni događaji') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="{{ route('system.admin.other.internal-events') }}">{{ __('Interni događaji') }}</a> /
    <a href="#">{{ $event->projectRel->name ?? '' }}</a>
@endsection

@section('c-buttons')
    <a href="{{ route('system.admin.trainings.instances') }}" title="{{ __('Pregled svih obuka') }}">
        <button class="pm-btn btn pm-btn-info">
            <i class="fas fa-chevron-left"></i>
            <span>{{ __('Nazad') }}</span>
        </button>
    </a>

    @if(isset($preview))
        <a href="{{ route('system.admin.other.internal-events.edit', ['id' => $event->id ]) }}">
            <button class="pm-btn pm-btn-white btn pm-btn-edit">
                <i class="fas fa-edit"></i>
            </button>
        </a>
        <a href="{{ route('system.admin.other.internal-events.delete', ['id' => $event->id ]) }}">
            <button class="pm-btn pm-btn-white btn pm-btn-trash">
                <i class="fas fa-trash"></i>
            </button>
        </a>
    @endif
@endsection

@section('content')
    <!-- Upload files GUI -->
    {{ html()->hidden('image_path')->class('form-control image_path')->value('files/upload/other/ie') }}
    {{ html()->hidden('file_path')->class('form-control file_path')->value(storage_path('files/other/ie')) }}
    {{ html()->hidden('file_type')->class('form-control file_type')->value('ie__file') }}
    {{ html()->hidden('model_id')->class('form-control model_id')->value($event->id) }}
    {{ html()->hidden('upload_route')->class('form-control upload_route')->value(route('system.admin.other.internal-events.save-files')) }}
    @include('admin.app.shared.files.file-upload')

    <div class="content-wrapper preview-content-wrapper">
        <div class="form__info">
            <div class="form__info__inner">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ html()->label(__('Projekat'))->for('project')->class('bold') }}
                            {{ html()->select('project', $projects, isset($event) ? $event->project : '')->class('form-control form-control-sm')->disabled(isset($preview)) }}
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ html()->label(__('Lokacija'))->for('location_id')->class('bold') }}
                            {{ html()->select('location_id', $locations, isset($event) ? $event->location_id : '')->class('form-control form-control-sm')->disabled(isset($preview)) }}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {{ html()->label(__('Datum'))->for('date')->class('bold') }}
                            {{ html()->text('date')->class('form-control form-control-sm datepicker')->value((isset($event) ? $event->date() : date('d.m.Y')))->isReadonly(isset($preview)) }}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {{ html()->label(__('Vrijeme'))->for('time')->class('bold') }}
                            {{ html()->select('time', $time, '08:00')->class('form-control form-control-sm single')->style('width:100%;')->value((isset($event) ? $event->time : '08:00'))->isReadonly(isset($preview)) }}
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ html()->label(__('YouTube link'))->for('youtube')->class('bold') }}
                            {{ html()->text('youtube')->class('form-control form-control-sm')->value((isset($event) ? $event->youtube : ''))->isReadonly(isset($preview)) }}
                        </div>
                    </div>
                </div>

                <br>

                <div class="instance__trainers">
                    <h4>{{ __('Učesnici događaja') }}</h4>
                    <div class="trainers">
                        <div class="trainer__w trainer__w_get_info" rel-id="" title="{{ __('Više informacija') }}">
                            <p> Šemso Poplava </p>
                        </div>
                        <div class="trainer__w trainer__w_get_info" rel-id="" title="{{ __('Više informacija') }}">
                            <p> Ideš Đurđa </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="right__menu__info">
            @include('admin.app.other.internal-events.snippets.right-menu')
        </div>
    </div>
@endsection
