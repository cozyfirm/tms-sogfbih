@extends('admin.layout.layout')
@section('c-icon')
    <img class="normal-icon" src="{{ asset('files/images/icons/book-bookmark-solid.svg') }}" alt="{{ __('Training-instance image') }}">
    <img class="yellow-icon" src="{{ asset('files/images/icons/book-bookmark-solid-yellow.svg') }}" alt="{{ __('Training instance image') }}">
@endsection
@section('c-title') {{ __('Izvještaj sa provedene obuke') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="#">...</a> /
    <a href="{{ route('system.admin.trainings.instances') }}">{{ __('Instance obuka') }}</a> /
    <a href="{{ route('system.admin.trainings.instances.preview', ['id' => $instance->id ]) }}">{{ __('Obuka') }}</a> /
    <a href="#">{{ __('Izvještaj sa provedene obuke') }}</a> /
@endsection

@section('c-buttons')
    <a href="{{ route('system.admin.trainings.instances.preview', ['id' => $instance->id ]) }}" title="{{ __('Nazad na pregled obuke') }}">
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
                <form action="{{ route('system.admin.trainings.instances.submodules.reports.update-report') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Instance ID -->
                    {{ html()->hidden('instance_id')->class('form-control')->value($instance->id) }}

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="mb-3">
                                {{ html()->label(__('Izvještaj sa održane obuke'))->for('report')->class('bold') }}
                                <input class="form-control" type="file" id="report" name="report">
                            </div>
                        </div>
                    </div>


                    <div class="row mt-4">
                        <div class="col-md-12 d-flex justify-content-end gap-5">
                            <button type="submit" class="yellow-btn">  {{ __('AŽURIRAJTE') }} </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
