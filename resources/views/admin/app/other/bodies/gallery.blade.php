@extends('admin.layout.layout')
@section('c-icon')
    <img class="normal-icon" src="{{ asset('files/images/icons/camera-retro-solid.svg') }}" alt="{{ __('Training-instance image') }}">
    <img class="yellow-icon" src="{{ asset('files/images/icons/camera-retro-solid-yellow.svg') }}" alt="{{ __('Training instance image') }}">
@endsection
@section('c-title') {{ __('Galerija fotografija') }} @endsection
@section('c-breadcrumbs')
    <a href="#"> <i class="fas fa-home"></i> <p>{{ __('Dashboard') }}</p> </a> /
    <a href="{{ route('system.admin.other.bodies') }}">{{ __('Organi i tijela') }}</a> /
    <a href="{{ route('system.admin.other.bodies.preview', ['id' => $body->id ]) }}">{{ $body->title ?? '' }}</a>
    <a href="#">{{ __('Galerija fotografija') }}</a>
@endsection

@section('c-buttons')
    <a href="{{ route('system.admin.other.bodies.preview', ['id' => $body->id ]) }}" title="{{ __('Nazad na pregled obuke') }}">
        <button class="pm-btn btn pm-btn-info">
            <i class="fas fa-chevron-left"></i>
            <span>{{ __('Nazad') }}</span>
        </button>
    </a>
@endsection

@section('content')
    <!-- Get images before displaying -->
    @php $images = FileHelper::getBodyImages($body->id); @endphp
        <!-- Set title of image -->
    @php $title = __('Interni događaji') @endphp
        <!-- Set route -->
    @php $route = 'system.admin.other.bodies.remove-file' @endphp

        <!-- Preview gallery images -->
    @include('admin.app.shared.gallery.preview')

    <!-- List of images -->
    @include('admin.app.shared.gallery.image-list')
@endsection

{{--{{ dd(FileHelper::getInstanceImages(2)) }}--}}

