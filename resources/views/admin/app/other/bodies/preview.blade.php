@extends('admin.layout.layout')
@section('c-icon') <i class="fas fa-info-circle"></i> @endsection
@section('c-title') {{ __('Organi i tijela') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="{{ route('system.admin.other.bodies') }}">{{ __('Organi i tijela') }}</a> /
    <a href="#">{{ $body->title ?? '' }}</a>
@endsection

@section('c-buttons')
    <a href="{{ route('system.admin.other.bodies') }}" title="{{ __('Nazad') }}">
        <button class="pm-btn btn pm-btn-info">
            <i class="fas fa-chevron-left"></i>
            <span>{{ __('Nazad') }}</span>
        </button>
    </a>

    @if(isset($preview))
        <a href="{{ route('system.admin.other.bodies.edit', ['id' => $body->id ]) }}">
            <button class="pm-btn pm-btn-white btn pm-btn-edit">
                <i class="fas fa-edit"></i>
            </button>
        </a>
        <a href="{{ route('system.admin.other.bodies.delete', ['id' => $body->id ]) }}">
            <button class="pm-btn pm-btn-white btn pm-btn-trash">
                <i class="fas fa-trash"></i>
            </button>
        </a>
    @endif
@endsection

@section('content')
    <!-- Upload files GUI -->
    {{ html()->hidden('image_path')->class('form-control image_path')->value('files/upload/other/bodies') }}
    {{ html()->hidden('file_path')->class('form-control file_path')->value(storage_path('files/other/bodies')) }}
    {{ html()->hidden('file_type')->class('form-control file_type')->value('body__file') }}
    {{ html()->hidden('model_id')->class('form-control model_id')->value($body->id) }}
    {{ html()->hidden('upload_route')->class('form-control upload_route')->value(route('system.admin.other.bodies.save-files')) }}
    @include('admin.app.shared.files.file-upload')

    <!-- Participants -->
    @include('admin.app.other.shared.participant')

    <div class="content-wrapper preview-content-wrapper">
        <div class="form__info">
            <div class="form__info__inner">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{ html()->label(__('Naslov'))->for('title')->class('bold') }}
                            {{ html()->text('title')->class('form-control form-control-sm')->value((isset($body) ? $body->title : ''))->isReadonly(isset($preview)) }}
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ html()->label(__('Kategorija'))->for('category')->class('bold') }}
                            {{ html()->select('category', $categories, isset($body) ? $body->category : '')->class('form-control form-control-sm')->disabled(isset($preview)) }}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {{ html()->label(__('Datum'))->for('date')->class('bold') }}
                            {{ html()->text('date')->class('form-control form-control-sm datepicker')->value((isset($body) ? $body->date() : date('d.m.Y')))->isReadonly(isset($preview)) }}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {{ html()->label(__('Vrijeme'))->for('time')->class('bold') }}
                            {{ html()->select('time', $time, '08:00')->class('form-control form-control-sm single')->style('width:100%;')->value((isset($body) ? $body->time : '08:00'))->isReadonly(isset($preview)) }}
                        </div>
                    </div>
                </div>

                <br>

                <div class="shared_participants @if(!$body->participantsRel->count()) d-none @endif">
                    <h4>{{ __('Učesnici događaja') }}</h4>
                    <div class="sp__wrapper">
                        @foreach($body->participantsRel as $participant)
                            <div class="participant_w participant__w_get_info" model-id="{{ $participant->id ?? '0' }}" title="{{ __('Više informacija') }}">
                                <p> {{ $participant->name ?? '' }} </p>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

        <div class="right__menu__info">
            @include('admin.app.other.bodies.snippets.right-menu')
        </div>
    </div>
@endsection
