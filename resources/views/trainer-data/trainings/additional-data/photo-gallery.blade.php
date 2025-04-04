@extends('admin.layout.layout')
@section('c-icon')
    <img class="normal-icon" src="{{ asset('files/images/icons/camera-retro-solid.svg') }}" alt="{{ __('Training-instance image') }}">
    <img class="yellow-icon" src="{{ asset('files/images/icons/camera-retro-solid-yellow.svg') }}" alt="{{ __('Training instance image') }}">
@endsection
@section('c-title') {{ __('Galerija fotografija') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="{{ route('system.trainer-data.trainings') }}">{{ __('Sistem obuka') }}</a> /
    <a href="{{ route('system.trainer-data.trainings.preview', ['id' => $instance->id ]) }}">{{ $instance->trainingRel->title ?? '' }}</a> /
    <a href="#">{{ __('Galerija fotografija') }}</a>
@endsection
@section('c-buttons')
    <a href="{{ route('system.trainer-data.trainings.preview', ['id' => $instance->id ]) }}" title="{{ __('Nazad na pregled obuke') }}">
        <button class="pm-btn btn pm-btn-info">
            <i class="fas fa-chevron-left"></i>
            <span>{{ __('Nazad') }}</span>
        </button>
    </a>
@endsection

@section('content')
    <!-- Get images before displaying -->
    @php $images = FileHelper::getInstanceImages($instance->id); @endphp
        <!-- Set title of image -->
    @php $title = __('Obuka') @endphp

        <!-- Preview gallery images -->
    @include('admin.app.shared.gallery.preview')

    <!-- List of images -->
    @include('admin.app.shared.gallery.image-list')
@endsection
