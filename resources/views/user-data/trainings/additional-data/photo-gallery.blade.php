@extends('admin.layout.layout')
@section('c-icon')
    <img class="normal-icon" src="{{ asset('files/images/icons/camera-retro-solid.svg') }}" alt="{{ __('Training-instance image') }}">
    <img class="yellow-icon" src="{{ asset('files/images/icons/camera-retro-solid-yellow.svg') }}" alt="{{ __('Training instance image') }}">
@endsection
@section('c-title') {{ __('Galerija fotografija') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="{{ route('system.user-data.trainings') }}">{{ __('Sistem obuka') }}</a> /
    <a href="{{ route('system.user-data.trainings.preview', ['id' => $instance->id ]) }}">{{ $instance->trainingRel->title ?? '' }}</a> /
    <a href="#">{{ __('Galerija fotografija') }}</a>
@endsection
@section('c-buttons')
    <a href="{{ route('system.user-data.trainings.preview', ['id' => $instance->id ]) }}" title="{{ __('Nazad na pregled obuke') }}">
        <button class="pm-btn btn pm-btn-info">
            <i class="fas fa-chevron-left"></i>
            <span>{{ __('Nazad') }}</span>
        </button>
    </a>
@endsection

@section('content')
    <div class="content-wrapper preview-content-wrapper">
        <div class="gallery__wrapper">
            @foreach(FileHelper::getInstanceImages($instance->id) as $image)
                <div class="image__out_wrapper">
                    <div class="image__wrapper">
                        <img src="{{ asset($image->getFile()) }}" alt="">
                    </div>
                    <div class="gallery__text__wrapper">
                        <div class="gtw__left">
                            <div class="gtw__image__wrapper">
                                <p>{{ $image->instanceRel->userRel->getInitials() }}</p>
                            </div>
                            <div class="text__">
                                <h6>{{ $image->instanceRel->userRel->name ?? '' }}</h6>
                                <p>{{ $image->instanceRel->userRel->email ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

{{--{{ dd(FileHelper::getInstanceImages(2)) }}--}}

